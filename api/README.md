# README

<p align="center">Teste Backend InCicle</p>

<p align="center">

    <a href="#Docker">Docker</a> -
    <a href="#Sobre">Sobre</a> -
    <a href="#Cityes">CRUD Cidade</a> -
    <a href="#People">CRUD Pessoas</a> -
    <a href="#Teste">Testes</a>
</p>





# Docker
<br>
<h3>Docker</h3>
<br>
<p>Para iniciar o docker, basta executar o arquivo <strong>up.bat</strong> e para desligar, use o <strong>down.bat</strong></p>








# Sobre

<p> Projeto construido com php 8.1 e larave 9. utilizando insomnia para testar API<br>

Rode os seguintes comandos antes da excecução de qualquer rota.<br>

<strong>composer install</strong>
<br>
<strong>composer update</strong>
<br>

    *Verifique as informações para a conexão com o DB no arquivo .env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=api
    DB_USERNAME=root
    DB_PASSWORD=

<br>
 Toda a base de dados foi construida usado as migrations do laravel, rode antes o código abaixo
<br>
<strong>php artisan migrate:fresh</strong>
</p>



# Cityes

<h3>Listagem</h3>
<br>
<p>Para fazer a listagem das cidades por estado basta acessar a rota <strong> post('api/cityes/index') </strong> passando a variavel<br>
{
    "paginate":"valor"  
}
</p>
<br>

<h3>Criar Cidades</h3>
<br>
<p>Para efetuar um insert , basta atraves da rota <strong>post('api/storage')</strong> enviar a seguinte estrutura em formato Json.

   
	"name":"Espirito Santo",
	"initials":"ES",
	"population":123549,
   
        "cityes":[{
			 
			"name":"Viana",        
            "iso_ddd": 66,
            "population": 987456, 
            "income_per_capital": 1900
			 
	}]


Na primeira parte temos os dados referentes ao Estado para serem salvos no sistema, logo abaixo temos uma estrutura "cityes" que é um vetor, nela podemos passar a quantidade de cidades necessarias que ao concluir todas pertencerão ao mesmo estado, ou seja, serão associadas.

</p>
<br>




<h3>Atualizar Cidade</h3>
<br>
<p> Para atualizar alguma informação de uma cidade especifica, basta acessar a rota <strong>put('api/update')</strong> e informar a estrutura em Json abaixo.


    "id":1,

    "cityes":[{

		"id":1,
		"name":"Viana",        
        "iso_ddd": 66,
        "population": 987456, 
        "income_per_capital": 1900
			 
	}]


Na estrutura "cityes" o "id" é pertencente a cidade que queremos atualizar, acima temos um "id" solto que pertence ao estado. Caso a cidade pertença ao Estado informado, a atualização é feito.
</p>
<br>


<h3>Show - Point End</h3>
<br>
<p> Para a exibição de apenas uma cidade, baste acessar a rota <strong>get('api/show)</strong> informando o seguinte Json

    {
        "name":"Gothan"
    }

Será feito uma busca no sistema e será caso achado, recebemos a cidade e o estado na quel ela pertence.
</p>
<br>


# People

<br>
<h3>Listagem</h3>
<br>

<p>Para listagem das pessoas, basta informarmos a rota <strong>post('people/index')</strong> e usarmos o Json.

	"paginate":1	
 </p>
 <br>

 <h3>Criar Pessoa</h3>
 <br>

<p>Use a rota <strong>post('api/people/storage')</strong> e passe o Json da seguinte forma.

	"name":"Escanor",
   	"cpf":"364.784.810-77",
   	"state":"ES",
   	"city":"Joana"



Os campos "state" e "city" funcionam basicamento juntos e para que se tenha um resultado positivo, "city" deve estar presente em "state".
</p>
<br>

<h3>Deletar Pessoa</h3>
<br>
<p> Para deletar de uma pessoas, basta informarmos a rota <strong>delete('api/people')</strong> e informar o Json

    "id":1

Basta informar o "id" da pessoa desejada.
</p>
<br>

<h3>Show - Point End</h3>
<br>
<p>Para encontrar uma pessoa, basta informarmos a rota <strong>get('api/people')</strong> e informar o Json

	"id":1

 Basta informar o "id" da pessoa desejada.   
</p>
<br>



# Teste

<h3>Sobre os testes</h3>
<br>
<p> 
    Os testes referentes a API tendem a retornar em grande maioria os codigos positivos, como os creates de pessoas e estados.

    Utiliza o ./vendor/bin/phpunit para chama-los.
    

</p>



