const DongGioHang = {
  props: { item: { type: Object, required: true } },
  emits: ['doi-so-luong', 'yeu-cau-xoa'],
  methods: {
    formatMoney(amount) { return new Intl.NumberFormat('vi-VN').format(amount) + ' đ'; }
  },
  template: `
    <div class="cart-row">
      <div>
        <h2>{{ item.name }}</h2>
        <p class="muted">Đơn giá: {{ formatMoney(item.price) }}</p>
        <div class="quantity-controls">
          <button type="button" class="secondary small" :disabled="item.quantity <= 1" @click="$emit('doi-so-luong', item.id, item.quantity - 1)" :aria-label="'Giảm ' + item.name">−</button>
          <span>{{ item.quantity }}</span>
          <button type="button" class="secondary small" :disabled="item.quantity >= 99" @click="$emit('doi-so-luong', item.id, item.quantity + 1)" :aria-label="'Tăng ' + item.name">+</button>
        </div>
      </div>
      <div class="row-end"><strong>{{ formatMoney(item.price * item.quantity) }}</strong><button type="button" class="danger-text" @click="$emit('yeu-cau-xoa', item.id)">Xóa</button></div>
    </div>`
};
