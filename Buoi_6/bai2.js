const { createApp } = Vue;

createApp({
  data() {
    return {
      customerName: '',
      showtimes: ['10:00', '14:30', '19:00'],
      showtime: '10:00',
      ticketType: 'regular',
      quantity: 1,
      hasCombo: false,
      confirmation: null
    };
  },
  computed: {
    validQuantity() {
      return Number.isInteger(this.quantity) && this.quantity >= 1 && this.quantity <= 10;
    },
    ticketPrice() {
      return this.ticketType === 'vip' ? 100000 : 70000;
    },
    total() {
      return this.validQuantity ? this.ticketPrice * this.quantity + (this.hasCombo ? 45000 : 0) : 0;
    },
    canBook() {
      return this.customerName.trim().length > 0 && this.validQuantity;
    }
  },
  methods: {
    formatMoney(value) {
      return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
    },
    increase() {
      if (this.validQuantity && this.quantity < 10) this.quantity++;
    },
    decrease() {
      if (this.validQuantity && this.quantity > 1) this.quantity--;
    },
    resetForm() {
      this.customerName = '';
      this.showtime = this.showtimes[0];
      this.ticketType = 'regular';
      this.quantity = 1;
      this.hasCombo = false;
      this.confirmation = null;
    },
    bookTickets() {
      if (!this.canBook) return;
      this.confirmation = {
        name: this.customerName,
        showtime: this.showtime,
        type: this.ticketType === 'vip' ? 'VIP' : 'thường',
        quantity: this.quantity,
        combo: this.hasCombo,
        total: this.total
      };
    }
  }
}).mount('#app');
