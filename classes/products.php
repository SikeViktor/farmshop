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

    public function getProductsByDate()
    {
        try {
            $stmt = "SELECT * FROM products 
                INNER JOIN product_categories 
                ON product_category_id = category_id
                ORDER BY product_created_at DESC";                
                
            $results = $this->connect()->query($stmt);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getCategories()
    {
        try {
            $stmt = "SELECT * FROM `product_categories`";
            $results = $this->connect()->query($stmt);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getCategoryById($id)
    {
        try {
            $stmt = $this->connect()->prepare("
            SELECT * FROM `product_categories` WHERE category_id=?");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getProductsByCategory($category)
    {
        try {
            $stmt = $this->connect()->prepare("
                SELECT * FROM products 
                INNER JOIN product_categories 
                ON product_category_id = category_id 
                WHERE product_category_id=?");
            $stmt->bindParam(1, $category);
            $stmt->execute();
            $products = $stmt->fetch(PDO::FETCH_ASSOC);
            return $products;
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

    public function getProductRating($product_id) {        
        try {
            $stmt = $this->connect()->prepare("SELECT AVG(rating) as rating FROM `product_rating` WHERE product_id = ?");
            $stmt->bindParam(1, $product_id);
            $stmt->execute();
            $number = $stmt->fetch(PDO::FETCH_ASSOC);
            $rating["int"] = intval($number["rating"]);
            $rating["float"] = $number["rating"] - $rating["int"];
            return $rating;
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
