# DER - Crimson Otaku

Arquivo visual:

```txt
DER.svg
```

## Tabelas

### categorias
- id (PK)
- nome
- descricao

### camisetas
- id (PK)
- categoria_id (FK)
- nome
- descricao
- preco
- imagem
- imagem2
- tamanho
- estoque
- ativo

### pedidos
- id (PK)
- camiseta_id (FK)
- cliente
- email
- telefone
- quantidade
- tamanho
- valor_total
- status
- data_pedido

### tags
- id (PK)
- nome

### camiseta_tags
- camiseta_id (PK/FK)
- tag_id (PK/FK)

## Relacionamentos

```txt
categorias 1 ---- N camisetas
camisetas  1 ---- N pedidos
camisetas  N ---- N tags
```

```txt
camisetas 1 ---- N camiseta_tags N ---- 1 tags
```
