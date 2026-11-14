const { createApp } = Vue;

createApp({
  data() {
    return {
      products: [],
      form: { name: '', price: '', stock: 0 },
      editingId: null,
      error: '',
      notice: '',
      loading: false,
      saving: false
    };
  },
  mounted() {
    this.loadProducts();
  },
  methods: {
    formatMoney(value) {
      return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
    },
    async request(url, options = {}) {
      const response = await fetch(url, options);
      let result;
      try {
        result = await response.json();
      } catch {
        throw new Error('Máy chủ không trả về JSON. Hãy mở trang qua Apache và kiểm tra PHP.');
      }
      if (!response.ok || !result.success) {
        throw new Error(result.message || 'Yêu cầu không thành công.');
      }
      return result;
    },
    async loadProducts() {
      this.loading = true;
      this.error = '';
      try {
        const result = await this.request('api/products.php');
        this.products = result.data;
      } catch (exception) {
        this.error = exception.message || 'Không thể tải sản phẩm.';
      } finally {
        this.loading = false;
      }
    },
    startEdit(product) {
      this.editingId = product.id;
      this.form = { name: product.name, price: product.price, stock: product.stock };
      this.error = '';
      this.notice = '';
    },
    resetForm() {
      this.editingId = null;
      this.form = { name: '', price: '', stock: 0 };
    },
    async saveProduct() {
      this.error = '';
      this.notice = '';
      const name = this.form.name.trim();
      if (!name || Array.from(name).length > 100 || !Number.isInteger(this.form.price) || this.form.price <= 0 || this.form.price > 2147483647 || !Number.isInteger(this.form.stock) || this.form.stock < 0 || this.form.stock > 2147483647) {
        this.error = 'Kiểm tra tên (1–100 ký tự), đơn giá nguyên dương và số lượng tồn nguyên không âm.';
        return;
      }
      this.saving = true;
      const isEditing = this.editingId !== null;
      try {
        await this.request(isEditing ? `api/products.php?id=${encodeURIComponent(this.editingId)}` : 'api/products.php', {
          method: isEditing ? 'PUT' : 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, price: this.form.price, stock: this.form.stock })
        });
        this.resetForm();
        await this.loadProducts();
        if (!this.error) this.notice = isEditing ? 'Đã cập nhật sản phẩm.' : 'Đã thêm sản phẩm.';
      } catch (exception) {
        this.error = exception.message || 'Không thể lưu sản phẩm.';
      } finally {
        this.saving = false;
      }
    },
    async deleteProduct(product) {
      if (!window.confirm(`Bạn có chắc muốn xóa "${product.name}"?`)) return;
      this.error = '';
      this.notice = '';
      try {
        await this.request(`api/products.php?id=${encodeURIComponent(product.id)}`, { method: 'DELETE' });
        if (this.editingId === product.id) this.resetForm();
        await this.loadProducts();
        if (!this.error) this.notice = 'Đã xóa sản phẩm.';
      } catch (exception) {
        this.error = exception.message || 'Không thể xóa sản phẩm.';
      }
    }
  }
}).mount('#app');
