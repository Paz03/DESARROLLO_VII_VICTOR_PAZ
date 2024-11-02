<?php
require_once "config_pdo.php";

class GestorTransacciones {
    private $pdo;
    private $maxReintentos = 3;
    private $retrasoReintento = 1;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function establecerNivelAislamiento($nivel) {
        $niveles = ['READ UNCOMMITTED', 'READ COMMITTED', 'REPEATABLE READ', 'SERIALIZABLE'];
        if (in_array($nivel, $niveles)) {
            $this->pdo->exec("SET SESSION TRANSACTION ISOLATION LEVEL " . $nivel);
            echo "Nivel de aislamiento establecido a: $nivel<br>";
        }
    }

    public function demostrarLecturaSucio() {
        try {
            $this->establecerNivelAislamiento('READ UNCOMMITTED');
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("UPDATE productos SET precio = precio * 1.1 WHERE id = ?");
            $stmt->execute([1]);
            sleep(2);
            $this->pdo->rollBack();
            echo "Transacción revertida<br>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function demostrarLecturaRepetible() {
        try {
            $this->establecerNivelAislamiento('REPEATABLE READ');
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->query("SELECT precio FROM productos WHERE id = 1");
            $precio1 = $stmt->fetchColumn();
            sleep(2);
            $stmt = $this->pdo->query("SELECT precio FROM productos WHERE id = 1");
            $precio2 = $stmt->fetchColumn();
            echo "Primera lectura: $precio1<br>";
            echo "Segunda lectura: $precio2<br>";
            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function ejecutarConReintentoDeDeadlock(callable $operacion) {
        $intentos = 0;
        
        while ($intentos < $this->maxReintentos) {
            try {
                $this->pdo->beginTransaction();
                $resultado = $operacion($this->pdo);
                $this->pdo->commit();
                return $resultado;
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                if ($this->esDeadlock($e) && $intentos < $this->maxReintentos - 1) {
                    $intentos++;
                    echo "Deadlock detectado, reintentando (intento $intentos)...<br>";
                    sleep($this->retrasoReintento);
                    continue;
                }
                throw $e;
            }
        }
    }

    private function esDeadlock(PDOException $e) {
        return $e->errorInfo[1] === 1213; 
    }

    public function transferirStock($origen_id, $destino_id, $cantidad) {
        return $this->ejecutarConReintentoDeDeadlock(function($pdo) use ($origen_id, $destino_id, $cantidad) {
            $ids = [$origen_id, $destino_id];
            sort($ids);
            foreach ($ids as $id) {
                $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ? FOR UPDATE");
                $stmt->execute([$id]);
            }

            $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
            $stmt->execute([$origen_id]);
            $stock_origen = $stmt->fetchColumn();
            
            if ($stock_origen < $cantidad) {
                throw new Exception("Stock insuficiente");
            }

            $stmt = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$cantidad, $origen_id]);

            $stmt = $pdo->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
            $stmt->execute([$cantidad, $destino_id]);

            return true;
        });
    }

    public function procesarVentaCompleja($cliente_id, $items) {
        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare("INSERT INTO ventas (cliente_id, total) VALUES (?, 0)");
            $stmt->execute([$cliente_id]);
            $venta_id = $this->pdo->lastInsertId();
            $this->pdo->exec("SAVEPOINT venta_creada");
            $total_venta = 0;
            $items_procesados = 0;

            foreach ($items as $item) {
                try {
                    $stmt = $this->pdo->prepare("SELECT stock, precio FROM productos WHERE id = ? FOR UPDATE");
                    $stmt->execute([$item['producto_id']]);
                    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($producto['stock'] < $item['cantidad']) {
                        throw new Exception("Stock insuficiente para producto {$item['producto_id']}");
                    }

                    $this->pdo->exec("SAVEPOINT item_" . $items_procesados);
                    $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                    $stmt->execute([$item['cantidad'], $item['producto_id']]);
                    $subtotal = $producto['precio'] * $item['cantidad'];
                    $stmt = $this->pdo->prepare("INSERT INTO detalles_venta (venta_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$venta_id, $item['producto_id'], $item['cantidad'], $producto['precio'], $subtotal]);
                    $total_venta += $subtotal;
                    $items_procesados++;
                } catch (Exception $e) {
                    $this->pdo->exec("ROLLBACK TO SAVEPOINT item_" . ($items_procesados - 1));
                    echo "Error procesando item: " . $e->getMessage() . "<br>";
                    continue;
                }
            }

            $stmt = $this->pdo->prepare("UPDATE ventas SET total = ? WHERE id = ?");
            $stmt->execute([$total_venta, $venta_id]);
            $this->pdo->commit();
            echo "Venta procesada exitosamente<br>";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en la transacción: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$gestor = new GestorTransacciones($pdo);

$gestor->demostrarLecturaSucio();
$gestor->demostrarLecturaRepetible();

try {
    $gestor->transferirStock(1, 2, 5);
    echo "Transferencia exitosa<br>";
} catch (Exception $e) {
    echo "Error en la transferencia: " . $e->getMessage();
}

// Ejemplo de procesamiento de venta compleja
$items = [
    ['producto_id' => 1, 'cantidad' => 2],
    ['producto_id' => 2, 'cantidad' => 1],
    ['producto_id' => 3, 'cantidad' => 3]
];

$gestor->procesarVentaCompleja(1, $items);
?>
