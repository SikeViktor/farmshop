<?php

class Orders extends Db
{
    public function createOrder($user_id, $total, $order_comment, $order_items)
    {
        try {
            $connect=$this->connect();
            $stmt = $connect->prepare("INSERT INTO order_details (user_id, total, order_comment) VALUES (?, ?, ?)");
            if (!$stmt->execute(array($user_id, $total, $order_comment))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }

            $order_id = $connect->lastInsertId();

            $stmt = $connect->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
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

    public function getOrders($user_id=null)
    {
        try {
            $sql="SELECT * FROM order_details ";
            if(!is_null($user_id)) {
                $sql .= "WHERE user_id=? ";
                $sql .= "ORDER BY created_at DESC";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(1, $user_id);
                $stmt->execute();
            } else {
                $sql .= "ORDER BY created_at DESC";
                $stmt = $this->connect()->query($sql);
            }
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orders;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getOrderItems($order_id)
    {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM order_items oi INNER JOIN products p ON oi.product_id=p.product_id WHERE order_id=?");
            $stmt->bindParam(1, $order_id);
            $stmt->execute();
            $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $orderItems;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }    

    public function countOrders()
    {
        try {
            $stmt = $this->connect()->prepare("SELECT COUNT(*) as count FROM order_details");            
            $stmt->execute();
            $countOrders = $stmt->fetch(PDO::FETCH_ASSOC)["count"];
            return $countOrders;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function calculateIncome()
    {
        try {
            $stmt = $this->connect()->prepare("SELECT SUM(total) as income FROM order_details");            
            $stmt->execute();
            $income = $stmt->fetch(PDO::FETCH_ASSOC)["income"];
            return $income;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
