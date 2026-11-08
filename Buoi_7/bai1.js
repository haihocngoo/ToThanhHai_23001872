const { createApp } = Vue;

createApp({
  data() {
    return {
      products: [
        { id: 1, name: 'Bàn phím cơ', price: 550000, category: 'Phụ kiện', stock: 8 },
        { id: 2, name: 'Chuột không dây', price: 220000, category: 'Phụ kiện', stock: 0 },
        { id: 3, name: 'Laptop học tập', price: 14500000, category: 'Máy tính', stock: 4 },
        { id: 4, name: 'Màn hình 24 inch', price: 3200000, category: 'Máy tính', stock: 3 },
        { id: 5, name: 'Tai nghe Bluetooth', price: 780000, category: 'Âm thanh', stock: 6 },
        { id: 6, name: 'Loa để bàn', price: 430000, category: 'Âm thanh', stock: 0 }
      ],
      categories: ['Phụ kiện', 'Máy tính', 'Âm thanh'],
      keyword: '',
      selectedCategory: '',
      sortOrder: '',
      searchNotice: '',
      pageStatus: 'Đang tải',
      formError: '',
      newProduct: { name: '', price: '', category: 'Phụ kiện', stock: 0 },
      nextId: 7
    };
  },
  computed: {
    visibleProducts() {
      const query = this.keyword.trim().toLocaleLowerCase('vi');
      const filtered = this.products.filter(product =>
        product.name.toLocaleLowerCase('vi').includes(query) &&
        (!this.selectedCategory || product.category === this.selectedCategory)
      );
      if (this.sortOrder === 'asc') return [...filtered].sort((a, b) => a.price - b.price || a.id - b.id);
      if (this.sortOrder === 'desc') return [...filtered].sort((a, b) => b.price - a.price || a.id - b.id);
      return filtered;
    },
    visibleCount() { return this.visibleProducts.length; },
    totalCount() { return this.products.length; },
    visibleInventoryValue() {
      return this.visibleProducts.reduce((sum, product) => sum + product.price * product.stock, 0);
    }
  },
  watch: {
    keyword(value) {
      this.searchNotice = Array.from(value.trim()).length === 1 ? 'Nhập thêm ký tự để tìm kiếm chính xác hơn.' : '';
    }
  },
  mounted() { this.pageStatus = 'Sẵn sàng'; },
  methods: {
    formatMoney(amount) { return new Intl.NumberFormat('vi-VN').format(amount) + ' đ'; },
    addProduct() {
      const { name, price, category, stock } = this.newProduct;
      if (!name.trim()) this.formError = 'Tên sản phẩm không được để trống.';
      else if (typeof price !== 'number' || !Number.isFinite(price) || price <= 0) this.formError = 'Giá phải lớn hơn 0.';
      else if (!Number.isInteger(stock) || stock < 0) this.formError = 'Số lượng tồn phải là số nguyên không âm.';
      else if (!this.categories.includes(category)) this.formError = 'Danh mục không hợp lệ.';
      else {
        this.products.push({ id: this.nextId++, name: name.trim(), price, category, stock });
        this.newProduct = { name: '', price: '', category: this.categories[0], stock: 0 };
        this.formError = '';
      }
    },
    deleteProduct(id) {
      const product = this.products.find(item => item.id === id);
      if (product && window.confirm(`Xóa sản phẩm "${product.name}"?`)) {
        this.products = this.products.filter(item => item.id !== id);
      }
    }
  }
}).mount('#app');
