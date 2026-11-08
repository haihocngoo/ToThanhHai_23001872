const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      purchaseNotice: '',
      products: [
        { id: 1, name: 'Bàn phím cơ', price: 550000, image: 'assets/keyboard.svg', description: 'Bàn phím gõ êm, phù hợp học tập và làm việc.', stock: 8 },
        { id: 2, name: 'Tai nghe', price: 780000, image: 'assets/headphones.svg', description: 'Tai nghe không dây với âm thanh rõ và pin lâu.', stock: 5 },
        { id: 3, name: 'Chuột máy tính', price: 220000, image: 'assets/mouse.svg', description: 'Chuột nhỏ gọn, kết nối không dây ổn định.', stock: 0 },
        { id: 4, name: 'Màn hình', price: 3200000, image: 'assets/monitor.svg', description: 'Màn hình 24 inch thích hợp cho học tập và giải trí.', stock: 3 }
      ]
    };
  },
  methods: {
    showPurchaseNotice(name) { this.purchaseNotice = `Đã chọn mua: ${name}.`; }
  }
});

app.component('the-san-pham', TheSanPham);
app.mount('#app');
