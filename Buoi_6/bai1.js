const { createApp } = Vue;

createApp({
  data() {
    return {
      student: {
        id: '23001872',
        name: 'Tô Thanh Hải',
        className: 'K68 - Khoa học máy tính',
        avatar: 'avatar.svg',
        gpa: 8.2,
        isStudying: true,
        introduction: 'Sinh viên yêu thích lập trình và tìm hiểu các công nghệ web.'
      },
      showIntro: false
    };
  },
  computed: {
    rank() {
      const score = this.student.gpa;
      if (score >= 8) return 'Giỏi';
      if (score >= 6.5) return 'Khá';
      if (score >= 5) return 'Trung bình';
      return 'Chưa đạt';
    },
    rankClass() {
      return {
        'rank-good': this.student.gpa >= 8,
        'rank-fair': this.student.gpa >= 6.5 && this.student.gpa < 8,
        'rank-average': this.student.gpa >= 5 && this.student.gpa < 6.5,
        'rank-low': this.student.gpa < 5
      };
    }
  }
}).mount('#app');
