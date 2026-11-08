const TheSanPham = {
  props: {
    ten: { type: String, required: true },
    gia: { type: Number, required: true },
    anh: { type: String, required: true },
    moTa: { type: String, default: 'Chưa có mô tả cho sản phẩm này.' },
    soLuongTon: { type: Number, default: 0 }
  },
  emits: ['mua'],
  data() { return { showDescription: false }; },
  methods: {
    formatMoney(amount) { return new Intl.NumberFormat('vi-VN').format(amount) + ' đ'; }
  },
  template: `
    <article class="product-card">
      <img :src="anh" :alt="'Ảnh ' + ten" class="product-image">
      <div class="product-content">
        <div class="product-head"><h2>{{ ten }}</h2><span class="stock" :class="soLuongTon > 0 ? 'in-stock' : 'out-of-stock'">{{ soLuongTon > 0 ? 'Còn hàng' : 'Hết hàng' }}</span></div>
        <p class="price">{{ formatMoney(gia) }}</p>
        <p class="muted">Tồn kho: {{ soLuongTon }}</p>
        <p v-if="showDescription" class="description">{{ moTa }}</p>
        <div class="card-actions">
          <button type="button" class="secondary" @click="showDescription = !showDescription">{{ showDescription ? 'Ẩn mô tả' : 'Xem mô tả' }}</button>
          <button type="button" :disabled="soLuongTon <= 0" @click="$emit('mua', ten)">Mua</button>
        </div>
      </div>
    </article>`
};
