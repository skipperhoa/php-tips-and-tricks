
$sql = "SELECT Customer.category, 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<18) THEN 1 ELSE 0 END) AS '18T', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>17 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<21) THEN 1 ELSE 0 END) AS '18T20', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>20 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<31) THEN 1 ELSE 0 END) AS '20T30', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>30 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<46) THEN 1 ELSE 0 END) AS '30T45', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>45 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<51) THEN 1 ELSE 0 END) AS '46T50',
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>50 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<56) THEN 1 ELSE 0 END) AS '51T55', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>55 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<61) THEN 1 ELSE 0 END) AS '56T60', 
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)>60 AND IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<100) THEN 1 ELSE 0 END) AS 'T60',
		SUM(CASE WHEN (IF(Customer.year_old>1000,YEAR(CURDATE())-Customer.year_old,Customer.year_old)<10) THEN 1 ELSE 0 END) AS 'KHAC'		
		FROM Customer WHERE status=0 and Date(Customer.Created_at) BETWEEN '2024-10-01' AND '2024-10-31' 
        AND category in('AAA','BBB','CCC')
		GROUP by Customer.category";


SELECT 
    Customer.category, 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) < 18) THEN 1 ELSE 0 END) AS '18T', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 18 AND 20) THEN 1 ELSE 0 END) AS '18T20', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 21 AND 30) THEN 1 ELSE 0 END) AS '20T30', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 31 AND 45) THEN 1 ELSE 0 END) AS '30T45', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 46 AND 50) THEN 1 ELSE 0 END) AS '46T50',
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 51 AND 55) THEN 1 ELSE 0 END) AS '51T55', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) BETWEEN 56 AND 60) THEN 1 ELSE 0 END) AS '56T60', 
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) > 60 AND IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) < 100) THEN 1 ELSE 0 END) AS 'T60',
    SUM(CASE WHEN (IF(Customer.year_old > 1000, YEAR(CURDATE()) - Customer.year_old, Customer.year_old) < 10) THEN 1 ELSE 0 END) AS 'KHAC'
FROM Customer 
WHERE 
    status = 0 
    AND DATE(Customer.Created_at) BETWEEN '2024-10-01' AND '2024-10-31'
    AND category IN ('AAA', 'BBB', 'CCC')
GROUP BY Customer.category;



WITH CustomerAge AS (
    SELECT 
        category,
        CASE 
            WHEN year_old > 1000 THEN YEAR(CURDATE()) - year_old 
            ELSE year_old 
        END AS age
    FROM customer
    WHERE category in('AAA','BBB','CCC')
        AND Date(created_at) BETWEEN '2024-10-01' AND '2024-10-31'
)
SELECT 
    category,
    SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) AS "18T",
    SUM(CASE WHEN age BETWEEN 18 AND 20 THEN 1 ELSE 0 END) AS "18T20",
    SUM(CASE WHEN age BETWEEN 21 AND 30 THEN 1 ELSE 0 END) AS "20T30",
    SUM(CASE WHEN age BETWEEN 31 AND 45 THEN 1 ELSE 0 END) AS "30T45",
    SUM(CASE WHEN age BETWEEN 46 AND 50 THEN 1 ELSE 0 END) AS "46T50",
    SUM(CASE WHEN age BETWEEN 51 AND 55 THEN 1 ELSE 0 END) AS "51T55",
    SUM(CASE WHEN age BETWEEN 56 AND 60 THEN 1 ELSE 0 END) AS "56T60",
    SUM(CASE WHEN age > 60 AND age < 100 THEN 1 ELSE 0 END) AS "T60",
    SUM(CASE WHEN age < 10 THEN 1 ELSE 0 END) AS "KHAC"
FROM CustomerAge
GROUP BY category;





UPDATE customer
SET category = ELT(FLOOR(RAND() * 3) + 1, 'iphone', 'xiaomi', 'oppo');

/**
SQL này cập nhật giá trị của cột category trong bảng customer bằng cách chọn ngẫu nhiên một trong ba giá trị: 
'iphone', 'xiaomi', hoặc 'oppo'.

RAND(): Hàm này tạo ra một số ngẫu nhiên giữa 0 và 1 (>0 & <1)

FLOOR(RAND() * 3) + 1:

RAND() * 3 nhân số ngẫu nhiên (từ 0 đến 1) với 3, kết quả là một số thực từ 0 đến 3.

FLOOR() lấy phần nguyên của số này (sẽ là 0, 1, hoặc 2).

+ 1 đảm bảo kết quả cuối cùng sẽ là 1, 2 hoặc 3.

Hàm ELT chọn phần tử dựa trên vị trí

*/