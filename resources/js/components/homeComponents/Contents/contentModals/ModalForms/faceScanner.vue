<template>
    <div class="relative h-screen flex items-center justify-center bg-gray-100">
      <button @click="toggle" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 transition-colors duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      <div class="floating-box">
        <video ref="video" autoplay muted playsinline width="300" height="225" />
        <div class="instructions">{{ message }}</div>
        <div class="progress-bar-container">
          <div class="progress-bar" :style="{ width: progress + '%' }"></div>
        </div>
        <button @click="startCheck" :disabled="checking">
          {{ checking ? 'Scanning...' : 'Start' }}
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        checking: false,
        message: 'Click Start to begin',
        progress: 0,
        stream: null,
      };
    },
    methods: {
      async startCheck() {
        this.checking = true;
        this.message = 'Initializing camera...';
        this.progress = 10;
  
        try {
          // Get user media
          this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
          this.$refs.video.srcObject = this.stream;
  
          this.message = 'Capturing image...';
          this.progress = 30;
  
          await this.sleep(1000); // Small delay to allow video feed to stabilize
  
          const imageBlob = await this.captureImage();
          this.progress = 60;
  
          // Convert image to Base64
          const base64Image = await this.blobToBase64(imageBlob);
  
          this.message = 'Sending to Face++ API...';
          this.progress = 80;
  
          const result = await this.detectFace(base64Image);
          this.progress = 100;
  
          if (result.faces && result.faces.length > 0) {
            this.toggle()
            this.checked()
          } else {
            alert('No face detected.');
          }
        } catch (error) {
          console.error(error);
          alert('Error: ' + error.message);
        } finally {
          this.checking = false;
          this.message = 'Click Start to begin';
          this.progress = 0;
          if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
          }
        }
      },
      captureImage() {
        return new Promise(resolve => {
          const video = this.$refs.video;
          const canvas = document.createElement('canvas');
          canvas.width = video.videoWidth || 300;
          canvas.height = video.videoHeight || 225;
          const ctx = canvas.getContext('2d');
          ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
          canvas.toBlob(resolve, 'image/jpeg');
        });
      },
      blobToBase64(blob) {
        return new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onloadend = () => resolve(reader.result.split(',')[1]);
          reader.onerror = reject;
          reader.readAsDataURL(blob);
        });
      },
      async detectFace(base64Image) {
        const apiKey = 'PlIHDJfAT7IEOo6LUbNgwSaYOrq-ChnL';
        const apiSecret = 'OWVdDPUaBVznrTehMxZeFFV2gkdPWl5I';
  
        const formData = new URLSearchParams();
        formData.append('api_key', apiKey);
        formData.append('api_secret', apiSecret);
        formData.append('image_base64', base64Image);
        formData.append('return_landmark', 0);
  
        const res = await axios.post(
          'https://api-us.faceplusplus.com/facepp/v3/detect',
          formData
        );
        return res.data;
      },
      sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
      },
    },
    props: ['toggle', 'checked'],
    mounted() {
      // Disable scrolling when component mounts
      document.querySelector(".parent-con").style.overflow = 'hidden';
    },
    beforeDestroy() {
      // Re-enable scrolling when component is destroyed
      document.querySelector(".parent-con").style.overflow = 'auto';
    },
    beforeUnmount() {
      // Re-enable scrolling when component is destroyed
      document.querySelector(".parent-con").style.overflow = 'auto';
    }
  };
  </script>
  
  <style scoped>
  .floating-box {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  .instructions {
    margin-top: 10px;
  }
  .progress-bar-container {
    height: 8px;
    background: #e0e0e0;
    margin-top: 10px;
    border-radius: 4px;
    overflow: hidden;
  }
  .progress-bar {
    height: 100%;
    background: #4caf50;
    transition: width 0.3s ease;
  }
  button {
    margin-top: 15px;
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  button:disabled {
    background: #93c5fd;
    cursor: not-allowed;
  }
  </style>
  