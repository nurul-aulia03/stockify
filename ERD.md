# ERD Stockify

**Sistem Informasi Inventaris dan Transaksi**

```mermaid
erDiagram
    USERS ||--o{ PURCHASES : creates
    USERS ||--o{ SALES : handles
    USERS ||--o{ STOCK_MOVEMENTS : records
    USERS ||--o{ ORDERS : places

    CATEGORIES ||--o{ PRODUCTS : contains
    SUPPLIERS ||--o{ PURCHASES : supplies

    PURCHASES ||--|{ PURCHASE_ITEMS : contains
    PRODUCTS ||--o{ PURCHASE_ITEMS : included_in

    SALES ||--|{ SALE_ITEMS : contains
    PRODUCTS ||--o{ SALE_ITEMS : sold_in

    PRODUCTS ||--o{ STOCK_MOVEMENTS : tracks

    ORDERS ||--o{ ORDER_ITEMS : contains
    PRODUCTS ||--o{ ORDER_ITEMS : ordered_as
```

## Keterangan Entitas

| Entitas | Fungsi |
|---|---|
| `users` | Menyimpan akun Admin, Staff, dan Customer. |
| `categories` | Menyimpan kategori produk. |
| `products` | Menyimpan data produk dan stok. |
| `suppliers` | Menyimpan data pemasok. |
| `purchases` | Mencatat transaksi pembelian barang. |
| `purchase_items` | Menyimpan rincian barang yang dibeli. |
| `sales` | Mencatat transaksi penjualan. |
| `sale_items` | Menyimpan rincian barang yang dijual. |
| `stock_movements` | Mencatat perubahan stok produk. |
| `orders` | Menyimpan pesanan pelanggan. |
| `order_items` | Menyimpan rincian produk dalam pesanan. |