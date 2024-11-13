<?php 
namespace App\Config;

interface Throwable {
    /* Methods */
    public function getMessage(): string;
    public function getCode(): int;
    public function getFile(): string;
    public function  getLine(): int;
    public function  getTrace(): array;
    public function getTraceAsString(): string;
    public function getPrevious(): ?Throwable;
    public function  __toString(): string;
   
}
class Exception implements Throwable {
    /* Properties */
    protected string $message = "";
    private string $string = "";
    protected int $code = 0;
    protected string $file = "";
    protected int $line = 0;
    private array $trace = [];
    private ?Throwable $previous = null;

    /* Methods */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null) {
        $this->message = $message;
        $this->code = $code;
        $this->previous = $previous;
    }

    final public function getMessage(): string {
        return $this->message;
    }

    final public function getPrevious(): ?Throwable {
        return $this->previous;
    }

    final public function getCode(): int {
        return $this->code;
    }

    final public function getFile(): string {
        return $this->file;
    }

    final public function getLine(): int {
        return $this->line;
    }

    final public function getTrace(): array {
        return $this->trace;
    }

    final public function getTraceAsString(): string {
        return implode("\n", $this->trace);
    }

    public function __toString(): string {
        return "{$this->message} in {$this->file} on line {$this->line}";
    }

    private function __clone(): void {}
}
?>
