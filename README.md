# Projeto "A MELHOR LOJA - PHP"
Trabalho desenvolvido para a matéria web 3, ministrada por Guilherme da Costa Silva, do curso de TSI da UTFPR Campus Guarapuava.

O projeto consiste em um sistema PHP utilizando o framework DW3, desenvolvido pelo professor Guilherme da Costa Silva.

Os requisitos do projeto constam em: https://moodle.utfpr.edu.br/pluginfile.php/2812768/mod_resource/content/0/Avalia%C3%A7%C3%A3o.pdf

As seguintes funcionalidades estão presentes:
```
- O sistema somente pode ser acessado por um usuário logado.
- Cadastro de usuário e login.
- Cadastro de oferta de produto. Informação mínima: descrição do produto,
preço e imagem.
- Listagem de ofertas disponíveis. Ordenar as mais antigas em primeiro. Filtrar
por descrição. Mostrar somente as ofertas disponíveis.
- Fechar negócio. Um usuário pode clicar em “comprar” e assim a oferta não
estará mais disponível. O dono da oferta não pode vender para ele mesmo.
Somente uma pessoa pode comprar em uma oferta.
- Relatório de compras do próprio usuário.
Relatório de vendas do próprio usuário.
- Deletar oferta. Uma oferta já finalizada não pode ser deletada. Só o dono da
oferta pode deletá-la.
- Testes automatizados.
```


# Framework Desenvolvimento para Web 3 (DW3)

Framework usado para ensinar PHP na universidade. Ele é composto por 14 classes em seu núcleo. Além disso, é necessário seguir a estrutura da pastas do projeto. O framework foi criado com base no Laravel, seguindo uma padronização bem parecida. Como o objetivo é ensinar PHP e web, o framework traz poucas funcionalidades, fazendo com que o aluno tenha que implementar bastante coisa. A ideia é fazer com que aluno aprenda o básico sobre programação em PHP e frameworks, para futuramente aprender o Laravel.

O framework foi projetado para ser usado com o servidor web Apache. Para usar outro servidor, é necessário configurá-lo para redirecionar quase todas as requisições para executar o arquivo "index.php" na raiz do projeto. Só não devem ser redirecionadas as requisições que apontarem para a pasta "publico", em que são armazenados os arquivos estáticos (CSS, JS, imagens, uploads).

Para criar um novo projeto usando o framework, basta copiar a pasta app4 ou app5 e renomeá-la para o nome do seu projeto. Depois é necessário ajustar algumas configurações no projeto. Primeiro deve ser editado o arquivo ".htaccess", para colocar o nome correto do projeto. Depois, é necessário alterar os arquivos da pasta "cfg", para configurar a conexão com o banco de dados e, no arquivo "geral.php", alterar o nome da aplicação e a URL_RAIZ do seu site.

As aulas de PHP estão disponíveis no Youtube: https://www.youtube.com/playlist?list=PLB3SJiuxVw395EktmlfJMLrPkfUFoRbX1
O framework é ensinado a partir do vídeo "Aula 7.1 Introdução ao framework"
