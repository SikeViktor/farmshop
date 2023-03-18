<?php

class Orders extends Db
{
    public function createOrder($user_id, $total, $order_comment, $order_items)
{
    try {
        $pdo = $this->connect();

        // Insert new order
        $stmt = $pdo->prepare("INSERT INTO order_details (user_id, total, order_comment) VALUES (?, ?, ?)");
        if (!$stmt->execute(array($user_id, $total, $order_comment))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $order_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");            
        foreach ($order_items as $item) {                
            if (!$stmt->execute(array($order_id, $item['product_id'], $item['quantity']))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
        }

        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}




}