const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      cart: [
        { id: 1, name: 'Bút', price: 5000, quantity: 2 },
        { id: 2, name: 'Vở', price: 12000, quantity: 3 }
      ]
    };
  },
  computed: {
    totalQuantity() { return this.cart.reduce((sum, item) => sum + item.quantity, 0); },
    totalPrice() { return this.cart.reduce((sum, item) => sum + item.price * item.quantity, 0); }
  },
  methods: {
    formatMoney(amount) { return new Intl.NumberFormat('vi-VN').format(amount) + ' đ'; },
    changeQuantity(id, quantity) {
      if (!Number.isInteger(quantity) || quantity < 1 || quantity > 99) return;
      if (!this.cart.some(item => item.id === id)) return;
      this.cart = this.cart.map(item => item.id === id ? { ...item, quantity } : item);
    },
    removeItem(id) { this.cart = this.cart.filter(item => item.id !== id); }
  }
});

app.component('dong-gio-hang', DongGioHang);
app.mount('#app');
