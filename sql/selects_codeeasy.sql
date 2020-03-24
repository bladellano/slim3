SELECT * FROM lojas;

SELECT * FROM produtos;

SELECT lojas.nome as loja,
  produtos.nome as produto,
  produtos.preco as preco,
  produtos.quantidade as quantidade
  FROM produtos
  INNER JOIN lojas ON produtos.loja_id = lojas.id
WHERE
  produtos.nome='Teclado'
  ORDER BY produtos.nome;

UPDATE produtos
  SET
  nome = 'Mouse',
  quantidade = 100
  WHERE
  nome = 'Teclado';