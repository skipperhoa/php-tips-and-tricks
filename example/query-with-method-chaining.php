<?php

$host = 'db';  // Tên dịch vụ MySQL trong Docker Compose
$db_name = 'db_hoanguyencoder';  // Tên cơ sở dữ liệu
$username = 'hoanguyencoder';  // Tên người dùng
$password = '12345678';  // Mật khẩu

// Kết nối đến MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối thành công!<br>";
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
require_once 'Expression.php';
interface BaseInterface{
    function table(string $table, string|null $as = null);
    function select(mixed $columns = ['*']);
    function where(Closure|string|array|Expression $column, mixed $operator = null, mixed $value = null, string $boolean = 'and');
    //function orWhere(Closure|string|array|Expression $column, mixed $operator = null, mixed $value = null);
    // function whereLike(Expression|string $column, string $value, bool $caseSensitive = false, string $boolean = 'and', bool $not = false);

    // function whereIn(Expression|string $column, mixed $values, string $boolean = 'and', bool $not = false);
    // function orWhereIn(Expression|string $column, mixed $values);
    // function whereInSub(Expression|string $column, Closure $values, string $boolean = 'and', bool $not = false);
    // function whereColumn(Expression|string|array $first, string|null $operator = null, string|null $second = null, string|null $boolean = 'and');
    // function whereNotIn(Expression|string $column, mixed $values, string $boolean = 'and');
    // function whereNull(string|array|Expression $columns, string $boolean = 'and', bool $not = false);
    // function orWhereNull(string|array|Expression $column);
    // function orderBy($column, string $direction = 'asc');
    // function groupBy(array|Expression|string ...$groups);
    // function update(array $values);
    // function insert(array $values);
    // function delete(mixed $id = null);
    // function limit(int $value);
    // function skip(int $value);
    // function offset(int $value);
    // function take(int $value);
    function get();
}



class QueryBuilder implements BaseInterface{

    private $pdo = null;
    private $table_name = null;
    private $wheres = [];
    private $select_columns = [];
    private $where_conditions = [];
    private $bindings = [];
    private $where_values = [];
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo; 
    }
    public function table(string $table, string|null $as = null)
    {
        $this->table_name = $table;
        return $this;
    }

    public function select(mixed $columns = ['*'])
    {
        $this->select_columns = $columns;

        return $this;
    }
    /*
     * @param mixed $operator 
     * ( =, >, <, >=, <=, <>, LIKE, v.v)
     * @param mixed $value (giá trị đầu vào, v.v)
     * name: cột cần so sánh.
     * operator: giá trị của $operator,toán tử =, >, <, >=, <=, <>, LIKE, v.v.
     * value: giá trị đầu vào, v.v.
     *  boolean: toán tử AND hoặc OR.
     * */
    public function where(Closure|string|array|Expression $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
    {
        $type = gettype($column);
        $results = match ($type) {
            'array' => call_user_func(function () use ($column,$boolean) {
                foreach ($column as $col) {
                    // Kiểm tra từng phần tử trong mảng để đảm bảo đúng định dạng
                    if (is_array($col) && count($col) === 3) {
                        $this->where_conditions[] = [
                            'column' => $col[0],
                            'operator' => $col[1],
                            'value' => $col[2],
                            'boolean' => $boolean
                        ];
                    }
                }
            }),
            'string' => $this->where_conditions[] = [
                'column' => $column,
                'operator' => $operator,    
                'value' => $value, 
                'boolean' => $boolean
            ],
            default =>$this->where_conditions[] = [
                'column' => $column,
                'operator' => $operator,    
                'value' => $value,  
                'boolean' => $boolean
            ]
        };
        print_r($this->where_conditions);
        return $this;
    }
  
    public function get()
    {
        $_select = $this->select_columns ? implode(', ', $this->select_columns) : '*';

        $sql = "SELECT $_select FROM " . $this->table_name;
        if (!empty($this->where_conditions && count($this->where_conditions) > 0)) {
            $sql .= " WHERE ";
            
            foreach ($this->where_conditions as $key=>$condition) {
                // Kiểm tra toán tử hợp lệ
                $allowedOperators = ['=', '>', '<', '>=', '<=', 'LIKE'];
                if (!in_array(strtoupper($condition['operator']), $allowedOperators)) {
                    throw new InvalidArgumentException("Invalid operator: " . $condition['operator']);
                }
                // Tạo placeholder duy nhất cho mỗi điều kiện
                $placeholder = ":param" . $key;
                $sql .= $condition['column'] . " " . $condition['operator'] . " $placeholder ";
               
                if ($key < count($this->where_conditions) - 1) {
                    $sql .= $condition['boolean'] . " ";
                }
                // Lưu placeholder và giá trị để ràng buộc sau
                $this->bindings[$placeholder] = ($condition['operator'] === 'LIKE') 
                ? '%' . $condition['value'] . '%' 
                : $condition['value'];
            }
           
        }
        //print_r($this->bindings);
        $stmt = $this->pdo->prepare($sql);
        // where
        if (!empty($this->where_conditions && count($this->where_conditions) > 0 && count($this->bindings) > 0)) {
            foreach ($this->bindings as $placeholder =>$value) {
                $stmt->bindValue($placeholder, $value);
            }
        }
       
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        //return $this;
    }

}

try {
 
        $query  = new QueryBuilder($pdo); // Tạo đối tượng Database với bảng 'QueryBuilder'
        // Ví dụ: Lấy người dùng với username = 'user'
        $results = $query ->table('User')
                    ->select(['id', 'username'])
                    ->where([['username','LIKE', 'user'],['email','LIKE', 'user']])
                    ->where('id', '>', 1)
                    ->get();

        foreach ($results as $row) {
        echo "ID: " . $row['id'] . " - Username: " . $row['username'] . "<br>";
        }

    } catch (PDOException $e) {
        die("Lỗi kết nối: " . $e->getMessage());
    }
?>