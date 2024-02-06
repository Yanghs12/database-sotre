## 초기화면
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>상품 관리 시스템</title>
</head>

<body>

    <h1>상품 관리 시스템</h1>
    <a href='cvs_select.php'> (1) 상품 조회 (조회 후 수정/삭제 가능) </a> <br><br>
    
    <a href='cvs_insert.php'> (2) 상품 등록 </a> <br><br>

    <FORM METHOD="get" ACTION="cvs_update.php">
        (3) 상품 수정 - 상품 이름 : <INPUT TYPE="text" NAME="name">
        <INPUT TYPE="submit" VALUE="수정">
    </FORM>

    <FORM METHOD="get" ACTION="cvs_delete.php">
        (4) 상품 삭제 - 상품 이름 : <INPUT TYPE="text" NAME="name">
        <INPUT TYPE="submit" VALUE="삭제">
    </FORM>

    <!-- Order Form -->
    <FORM METHOD="post" ACTION="order.php">
        (5) 상품 주문 - 상품 이름 : <INPUT TYPE="text" NAME="name">
        수량: <INPUT TYPE="number" NAME="quantity" min="1" required> <!-- 추가된 부분 -->
        <INPUT TYPE="submit" VALUE="주문">
    </FORM>

</body>

</html>


## INSERT
<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
</HEAD>
<BODY>

<h1> 상품 정보 입력  </h1>
<FORM METHOD="post" ACTION="cvs_insert_result.php">
  
    상품 이름 : <INPUT TYPE ="text" NAME="name"> <br>
    가격 : <INPUT TYPE ="text" NAME="price"> <br>
    카테고리 ID : 
    <SELECT NAME="categoryID">
        <OPTION VALUE="1">음료</OPTION>
        <OPTION VALUE="2">과자</OPTION>
	<OPTION VALUE="3">아이스크림</OPTION>
        <OPTION VALUE="4">담배</OPTION>
	<OPTION VALUE="5">약품</OPTION>
       <OPTION VALUE="6">사탕</OPTION>
	<OPTION VALUE="7">초콜릿</OPTION>
    </SELECT>
    <br>
    재고 수량 : <INPUT TYPE ="text" NAME="stockQuantity"> <br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="상품 입력">
</FORM>

</BODY>
</HTML>


##INSERRT_result
<?php
    $con=mysqli_connect("localhost", "root", "1234", "store") or die("MySQL 접속 실패");


    $name = $_POST["name"];
    $price = $_POST["price"];
    $categoryID = $_POST["categoryID"];
    $stockQuantity = $_POST["stockQuantity"];

    $sql = "INSERT INTO product (name, price, category_id, stock_quantity) 
            VALUES ( '$name', $price, $categoryID, $stockQuantity)";

    $ret = mysqli_query($con, $sql);

    echo "<h1> 상품 입력 결과 </h1>";
    if($ret) {
        echo "데이터가 성공적으로 입력됨.";
    } else {
        echo "데이터 입력 실패"."<br>";
        echo "실패 원인: ".mysqli_error($con);
    }
    mysqli_close($con);

    echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
?>




##UPDATE
<?php
$con=mysqli_connect("localhost", "root", "1234", "store") or die("MySQL 접속 실패");
$sql ="SELECT * FROM product WHERE name='".$_GET['name']."'";

$ret = mysqli_query($con, $sql);
if($ret) {
    $count = mysqli_num_rows($ret);
    if ($count==0) {
        echo $_GET['name']." 상품이 없음!!"."<br>";
        echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
        exit();
    }
}
else {
    echo "데이터 조회 실패!!"."<br>";
    echo "실패 원인: ".mysqli_error($con);
    echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
    exit();
}
$row = mysqli_fetch_array($ret);
$productID = $row['id'];
$name = $row["name"];
$price = $row["price"];
$categoryID = $row["category_id"];
$stockQuantity = $row["stock_quantity"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
</HEAD>
<BODY>

<h1> 상품 정보 수정 </h1>
<FORM METHOD="post" ACTION="cvs_update_result.php">
    상품 ID : <INPUT TYPE ="text" NAME="productID" VALUE=<?php echo $productID ?>
        READONLY> <br>
    상품 이름 : <INPUT TYPE ="text" NAME="name" VALUE=<?php echo $name ?>> <br>
    가격 : <INPUT TYPE ="text" NAME="price" VALUE=<?php echo $price ?>> <br>
    카테고리 ID : <INPUT TYPE ="text" NAME="categoryID" VALUE=<?php echo $categoryID ?>> <br>
    재고 수량 : <INPUT TYPE ="text" NAME="stockQuantity" VALUE=<?php echo $stockQuantity ?>> <br>
    <BR><BR>
    <INPUT TYPE="submit" VALUE="정보 수정">
</FORM>

</BODY>
</HTML>


##UPDATE_RESULT
<?php
    $con=mysqli_connect("localhost", "root", "1234", "store") or die("MySQL 접속 실패");

    $productID = $_POST["productID"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $categoryID = $_POST["categoryID"];
    $stockQuantity = $_POST["stockQuantity"];

    $sql = "UPDATE product SET name='".$name."', price=".$price;
    $sql = $sql.", category_id=".$categoryID.", stock_quantity=".$stockQuantity;
    $sql = $sql." WHERE id='".$productID."'";

    $ret = mysqli_query($con, $sql);

    echo "<h1> 상품 정보 수정 결과 </h1>";
    if($ret) {
        echo "데이터가 성공적으로 수정됨.";
    }
    else {
        echo "데이터 수정 실패!!"."<br>";
        echo "실패 원인: ".mysqli_error($con);
    }
    mysqli_close($con);

    echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
?>


##DELETE
<?php
$con=mysqli_connect("localhost", "root", "1234", "store") or die("MySQL 접속 실패");
$sql ="SELECT * FROM product WHERE name='".$_GET['name']."'";

$ret = mysqli_query($con, $sql);
if($ret) {
    $count = mysqli_num_rows($ret);
    if ($count==0) {
        echo $_GET['productID']." 상품이 없음!!"."<br>";
        echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
        exit();
    }
}
else {
    echo "데이터 조회 실패!!"."<br>";
    echo "실패 원인: ".mysqli_error($con);
    echo "<br> <a href='cvs.php'> <-- 초기 화면</a> ";
    exit();
}
$row = mysqli_fetch_array($ret);
$productID = $row['id'];
$name = $row["name"];
$price = $row["price"];
$categoryID = $row["category_id"];
$stockQuantity = $row["stock_quantity"];
?>

<HTML>
<HEAD>
<META http-equiv="content-type" content="text/html; charset=utf-8">
</HEAD>
<BODY>

<h1> 상품 삭제 </h1>
<FORM METHOD="post" ACTION="delete_result.php">
    상품 ID : <INPUT TYPE ="text" NAME="productID" VALUE=<?php echo $productID ?>
        READONLY> <br>
    상품 이름 : <INPUT TYPE ="text" NAME="name" VALUE=<?php echo $name ?>
        READONLY> <br>
    가격 : <INPUT TYPE ="text" NAME="price" VALUE=<?php echo $price ?>
        READONLY> <br>
    카테고리 ID : <INPUT TYPE ="text" NAME="categoryID" VALUE=<?php echo $categoryID ?>
        READONLY> <br>
    재고 수량 : <INPUT TYPE ="text" NAME="stockQuantity" VALUE=<?php echo $stockQuantity ?>
        READONLY> <br>
    <BR><BR>
    위 상품을 삭제하겠습니까?
    <INPUT TYPE="submit" VALUE="상품 삭제">
</FORM>

</BODY>
</HTML>



##DELETE_RESULT
<?php
    $con=mysqli_connect("localhost", "root", "1234", "sqlDB") or die("MySQL 접속 실패");

    $userID = $_POST["userID"];

    $sql ="DELETE FROM userTBL WHERE userID='".$userID."'";

    $ret = mysqli_query($con, $sql);

    echo "<h1> 회원 삭제 결과 </h1>";
    if($ret) {
        echo $userID." 상품이  삭제됨..";
    }
    else {
        echo "데이터 삭제 실패!!"."<br>";
        echo "실패 원인: ".mysqli_error($con);
    }
    mysqli_close($con);

    echo "<br><br> <a href='cvs.php'> <-- 초기 화면</a>";
?>

##ORDER.PHP
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "1234", "store") or die("MySQL 접속 실패");

    $productName = $_POST["name"];
    $orderedQuantity = $_POST["quantity"]; // 주문 수량 추가

    // 상품명을 기반으로 데이터베이스에서 상품 세부 정보를 가져옴
    $sql = "SELECT * FROM product WHERE name='$productName'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_array($result);

        // 상품이 재고에 있는지 및 주문 가능한 수량인지 확인
        if ($row['stock_quantity'] > 0 && $row['stock_quantity'] >= $orderedQuantity) {
            // 여기에 주문 처리 로직을 추가할 수 있습니다.
            // 예를 들어, 재고 수량 업데이트, 주문 세부 정보 저장 등

            // 재고 수량 업데이트
            $newStockQuantity = $row['stock_quantity'] - $orderedQuantity;
            $updateSql = "UPDATE product SET stock_quantity=$newStockQuantity WHERE name='$productName'";
            $updateResult = mysqli_query($con, $updateSql);

            if ($updateResult) {
                echo "<h1>주문 완료</h1>";
                echo "<p>상품을 성공적으로 주문했습니다.</p>";
                echo "<p>주문 수량: $orderedQuantity</p>";
                echo "<p>남은 수량: $newStockQuantity</p>";
            } else {
                echo "주문 실패: " . mysqli_error($con);
            }
        } else {
            echo "<h1>주문 실패</h1>";
            if ($row['stock_quantity'] <= 0) {
                echo "<p>죄송합니다. 해당 상품은 품절되었습니다.</p>";
            } else {
                echo "<p>주문 가능한 수량이 부족합니다.</p>";
            }
        }
    } else {
        echo "상품 조회 실패: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    header("Location: index.php");
    exit();
}
?>
