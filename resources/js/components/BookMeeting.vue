<template>
  <div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Book a Meeting Room</h2>

    <form @submit.prevent="bookMeeting">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Name of Meeting</label>
        <input v-model="meeting.meeting_name" type="text" class="mt-1 p-2 w-full border rounded" required />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Date and Time</label>
        <input v-model="meeting.start_time" type="datetime-local" class="mt-1 p-2 w-full border rounded" :min="minDateTime" required />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Duration</label>
        <select v-model="meeting.duration" class="mt-1 p-2 w-full border rounded">
          <option value="30">30 mins</option>
          <option value="60">60 mins</option>
          <option value="90">90 mins</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Members</label>
        <input v-model.number="meeting.members" type="number" min="1" max="15" class="mt-1 p-2 w-full border rounded" required />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Meeting Room</label>
        <select v-model="meeting.meeting_room_id" class="mt-1 p-2 w-full border rounded">
          <option v-for="room in availableRooms" :key="room.id" :value="room.id">
            {{ room.name }} - Capacity: {{ room.capacity }}
          </option>
        </select>
      </div>

      <button type="submit" class="bg-blue-500 text-white p-2 rounded">Book Meeting Room</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      meeting: {
        name: '',
        dateTime: '',
        duration: 30,
        members: 1,
        room: ''
      },
      rooms: [
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
    },
    availableRooms() {
      return this.rooms.filter(room => room.capacity >= this.meeting.members);
    }
  },
  methods: {
    async bookMeeting() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/book-meeting', {
          method: 'POST',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify(this.meeting)
        });

        if (response.ok) {
          alert('Meeting booked successfully');
          this.resetForm();
        } else {
          const data = await response.json();
          alert(data.message || 'Failed to book meeting');
        }
      } catch (error) {
        console.error('Error booking meeting:', error);
        alert('Error booking meeting');
      }
    },
    resetForm() {
      this.meeting = {
        name: '',
        dateTime: '',
        duration: 30,
        members: 1,
        room: ''
      };
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
}
</style>
    