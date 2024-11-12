
/* 📌
1️⃣ :  SQL Query to count customers by age group
 */
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


/* 🟢 or */
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


/* 📌
2️⃣ : Cập nhật giá trị của cột category trong bảng customer bằng cách chọn ngẫu nhiên một trong ba giá trị: 
'iphone', 'xiaomi', hoặc 'oppo'.
RAND(): Hàm này tạo ra một số ngẫu nhiên giữa 0 và 1 (>0 & <1)

FLOOR(RAND() * 3) + 1:

RAND() * 3 nhân số ngẫu nhiên (từ 0 đến 1) với 3, kết quả là một số thực từ 0 đến 3.

FLOOR() lấy phần nguyên của số này (sẽ là 0, 1, hoặc 2).

+ 1 đảm bảo kết quả cuối cùng sẽ là 1, 2 hoặc 3.

Hàm ELT chọn phần tử dựa trên vị trí
 */
UPDATE customer
SET category = ELT(FLOOR(RAND() * 3) + 1, 'iphone', 'xiaomi', 'oppo');



/** 📌
3️⃣ : SQL Query to rank employees within each department based on salary:
rank() là hàm xếp hạng (ranking function) trong SQL.
OVER xác định phạm vi tính toán của hàm rank().
PARTITION BY depname chia dữ liệu theo từng depname (tức là chia thành các nhóm dựa trên tên phòng ban). Mỗi phòng ban là một nhóm riêng biệt.
ORDER BY salary DESC xếp hạng theo cột salary trong mỗi nhóm, theo thứ tự giảm dần (tức là nhân viên có lương cao nhất sẽ được xếp hạng 1 trong phòng ban của mình).
*/
SELECT depname, empno, salary,
       rank() OVER (PARTITION BY depname ORDER BY salary DESC)
FROM empsalary;

/* Example demo */
-- Tạo bảng empsalary
CREATE TABLE empsalary (
    depname VARCHAR(50),
    empno INT,
    salary DECIMAL(10, 2)
);

-- Chèn dữ liệu mẫu vào bảng empsalary
INSERT INTO empsalary (depname, empno, salary) VALUES
('Sales', 101, 5000),
('Sales', 102, 4500),
('Sales', 103, 5200),
('Sales', 104, 4700),
('Sales', 105, 5300),
('HR', 201, 6000),
('HR', 202, 5800),
('HR', 203, 6200),
('HR', 204, 5900),
('HR', 205, 6100),
('IT', 301, 7000),
('IT', 302, 7200),
('IT', 303, 6900),
('IT', 304, 7100),
('IT', 305, 7400),
('Marketing', 401, 4800),
('Marketing', 402, 4600),
('Marketing', 403, 4900),
('Marketing', 404, 4700),
('Marketing', 405, 4500);


