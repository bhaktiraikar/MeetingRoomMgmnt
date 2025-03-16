<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
      <h2 class="text-center text-2xl font-bold">Dashboard</h2>
        <p>Welcome to the dashboard!</p>
        <p class="text-center">Welcome, {{ user.name }}</p>
        <router-link to="/book-meeting">Book Meeting Room</router-link>
      <button @click="logout" class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">Logout</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: {}
    };
  },
  async created() {
    await this.getUser();
  },
  methods: {
    async getUser() {
      const token = localStorage.getItem('token');
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/user', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        this.user = response.data;
      } catch (error) {
        console.error('Error fetching user:', error);
      }
    },
    async logout() {
      const token = localStorage.getItem('token');
      await axios.post('http://127.0.0.1:8000/api/logout', {}, {
        headers: { Authorization: `Bearer ${token}` }
      });
      localStorage.removeItem('token');
      this.$router.push('/login');
    }
  }
};
</script>
