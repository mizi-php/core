### Code

Aplica e remove codificação em hash MD5

### Chave de codificação

A classe **Code** utiliza uma chave para criar as strings codificadas. 
Uma vez criada, so será possivel recuperar o **md5** da string. 

Para altear a chave de codificação, adicione a linha em seu .env

    CODE_KEY=olaMundo


### Utilizando a classe estatica

> A classe estatica sempre usa a chave definida nas variaveis de ambiente

    use Mizi\Code;
    
Retorna o codigo de uma string

    Code::on(string $string): string

Retonra o MD5 usado para gerar uma string codificada

    Code::off(string $string): string

Verifica se uma string é uma string codificada

    Code::check(string $string): bool

Verifica se duas strings tem a mesma string codificada

    Code::compare(string $string, string $compare): bool

### Criando objeto de Code

Utilize instancias de Code para compatibilidade com outros projetos que não compartilham a mesma chave. 
Defina a chave que a instancia deve utilizar no parametro **$key**

    $code = new \Mizi\Instance\Code($key);

Retorna o codigo de uma string

    $code->on(string $string): string

Retonra o MD5 usado para gerar uma string codificada

    $code->off(string $string): string

Verifica se uma string é uma string codificada

    $code->check(string $string): bool

Verifica se duas strings tem a mesma string codificada

    $code->compare(string $string, string $compare): bool
