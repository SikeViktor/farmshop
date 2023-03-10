<?php

class Products extends Db
{

    public function getProducts()
    {
        try {
            $stmt = "SELECT * FROM products 
                INNER JOIN product_categories 
                ON product_category_id = category_id";
            $results = $this->connect()->query($stmt);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getProductById($id)
    {
        try {
            $stmt = $this->connect()->prepare("
                SELECT * FROM products 
                INNER JOIN product_categories 
                ON product_category_id = category_id 
                WHERE product_id=?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function newProduct($product_name, $product_description, $category_name, $product_quantity, $product_price, $product_discount_percent, $product_img_path)
    {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO products (product_name, product_description, product_category_id, product_quantity, product_price, product_discount_percent, product_img_path)
                                            SELECT ?, ?, product_categories.category_id, ?, ?, ?, ?
                                            FROM product_categories
                                            WHERE category_name = ?");

            if (!$stmt->execute(array($product_name, $product_description, $product_quantity, $product_price, $product_discount_percent, $product_img_path, $category_name))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateBrooding($start_date, $done_date, $chick_number, $alive, $age, $id)
    {
        try {
            $stmt = $this->connect()->prepare("UPDATE brooding SET start_date = ?, done_date=?, chick_number=?, alive=?, age=? WHERE id=?");

            if (!$stmt->execute(array($start_date, $done_date, $chick_number, $alive, $age, $id))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteBrooding($id)
    {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM brooding WHERE id=?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
