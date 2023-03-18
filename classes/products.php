<?php

use function PHPSTORM_META\type;

class Products extends Db
{

    //Termékek lekérdezése
    //összes termék listázása, keresés, megfelelő számú megjelenítés
    /*public function getProducts(...$params)
    {
        try {            
            $name = $params[0] . '%';                
            $element=$params[2];
            $offset = ($params[1] - 1) * $element;
            $sortByField = $params[3];
            $sortDirection = $params[4];

            //paraméter nélkül meghívva
            if (empty($params)) {
                $stmt = $this->connect()->prepare("SELECT * FROM products 
                        INNER JOIN product_categories 
                        ON product_category_id = category_id");
            
            } else 
            //egy paraméterrel meghívva, név keresés
            if (count($params) == 1) {                                
                $stmt = $this->connect()->prepare("SELECT * FROM products 
                        INNER JOIN product_categories 
                        ON product_category_id = category_id
                        WHERE product_name LIKE ?");                
                $stmt->bindParam(1, $name);
            }else 
            //három paraméter : név, oldal, egy oldalon megjelenő elemek száma
            if (count($params) == 3) {                               
                $stmt = $this->connect()->prepare("SELECT * FROM products 
                        INNER JOIN product_categories 
                        ON product_category_id = category_id
                        WHERE product_name LIKE ? 
                        LIMIT ? OFFSET ?");
                $stmt->bindParam(1, $name);
                $stmt->bindParam(2, $element, PDO::PARAM_INT);
                $stmt->bindParam(3, $offset, PDO::PARAM_INT);
            }
            else 
            //öt paraméter : név, oldal, egy oldalon megjelenő elemek száma, rendezés mező szerint, rendezés iránya
            if (count($params) == 5) {                               
                $stmt = $this->connect()->prepare("SELECT * FROM products 
                        INNER JOIN product_categories 
                        ON product_category_id = category_id
                        WHERE product_name LIKE ?
                        ORDER BY $sortByField $sortDirection
                        LIMIT ? OFFSET ?");
                $stmt->bindParam(1, $name);               
                $stmt->bindParam(2, $element, PDO::PARAM_INT);
                $stmt->bindParam(3, $offset, PDO::PARAM_INT);                
            }
            
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }*/

    public function getProducts($name = null, $category = null, $sortByField = null, $sortDirection = null, $limit = null, $offset = null)
    {
        try {
            $sql = "SELECT * FROM products INNER JOIN product_categories ON product_category_id = category_id";
            $params = array();

            if (!empty($name)) {
                $sql .= " WHERE product_name LIKE :name";
                $params['name'] = "$name%";
            }

            if (!empty($category)) {
                $sql .= " AND product_category_id = :category";
                $params['category'] = $category;
            }

            if (!empty($sortByField) && !empty($sortDirection)) {
                $sql .= " ORDER BY $sortByField $sortDirection";
            }

            /*if (!is_null($limit) && !is_null($offset)) {                
                $sql .= " LIMIT :limit OFFSET :offset";
                $params['limit'] = intval($limit);
                $params['offset'] = intval(($offset-1) * $limit);
                                
            }*/

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
            

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //termék lekérdezése id szerint
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

    //Kategóriák lekérdezése
    //termékek kategóriáinak lekérése
    public function getCategories()
    {
        try {
            $stmt = "SELECT * FROM `product_categories`";
            $results = $this->connect()->query($stmt)->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //termék kategória id szerint
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

    public function getProductRating($product_id)
    {
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
}
