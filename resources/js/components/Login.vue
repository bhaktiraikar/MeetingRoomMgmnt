<template>
  <div>
    <h1>Book a Meeting Room</h1>
    <form @submit.prevent="bookMeeting">
      <div>
        <label>Meeting Name:</label>
        <input type="text" v-model="meetingName" required />
      </div>
      <div>
        <label>Date and Time:</label>
        <input type="datetime-local" v-model="dateTime" :min="minDateTime" required />
      </div>
      <div>
        <label>Duration:</label>
        <select v-model="duration">
          <option value="30">30 mins</option>
          <option value="60">60 mins</option>
          <option value="90">90 mins</option>
        </select>
      </div>
      <div>
        <label>Members:</label>
        <input type="number" v-model="members" min="1" max="15" required />
      </div>
      <div>
        <label>Meeting Room:</label>
        <select v-model="selectedRoom">
          <option v-for="room in availableRooms" :key="room.id" :value="room.id">
            {{ room.name }} (Capacity: {{ room.capacity }})
          </option>
        </select>
      </div>
      <button type="submit">Book Meeting</button>
    </form>
    <router-link to="/dashboard">Back to Dashboard</router-link>
    <router-link to="/book-meeting">Book Meeting Room</router-link>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      meetingName: '',
      dateTime: '',
      duration: 30,
      members: 1,
      selectedRoom: null,
      availableRooms: [
        { id: 1, name: 'Meeting Room 1', capacity: 3 },
        { id: 2, name: 'Meeting Room 2', capacity: 10 },
        { id: 3, name: 'Meeting Room 3', capacity: 15 },
        { id: 4, name: 'Meeting Room 4', capacity: 2 },
        { id: 5, name: 'Meeting Room 5', capacity: 1 }
      ]
    };
  },
  computed: {
    minDateTime() {
      const now = new Date();
      return now.toISOString().slice(0, 16);
    }
  },
  methods: {
    async bookMeeting() {
      try {
        const response = await axios.post('/api/book-meeting', {
          meeting_name: this.meetingName,
          date_time: this.dateTime,
          duration: this.duration,
          members: this.members,
          meeting_room_id: this.selectedRoom
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });

        console.log('Booking response:', response.data);
      } catch (error) {
        console.error('Error booking meeting:', error);
      }
    }
  }
};
</script>

<style scoped>
div {
  margin-bottom: 15px;
}
label {
  display: block;
  margin-bottom: 5px;
}
input, select, button {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}
</style>
