### Import

Importa arquivos retornando conteúdo

    use Mizi\Import;

---

**content**: Retorna o conteúdo de um aquivo

    content($filePath): ?string

---

**return**: Retorna o resultado (return) em um arquivo php 

    return(string $filePath, array $params = [], bool $prepare = true): mixed

---

**var**: Retorna o valor de uma variavel dentro de em um arquivo php 

    var(string $filePath, string $varName, array $params = [], bool $prepare = true): mixed

---

**output**: Retorna a saída de texto gerada por um arquivo

    output(string $filePath, array $params = [], bool $prepare = true): string

---