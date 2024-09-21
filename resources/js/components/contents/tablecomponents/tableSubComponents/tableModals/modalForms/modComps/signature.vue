<template>
  <div class="flex gap-2">
    <div class="w-full">
      <canvas
        ref="signatureCanvas"
        class="border border-gray-300 rounded-lg mt-2 h-40"
        @mousedown="startDrawing"
        @mouseup="stopDrawing"
        @mousemove="draw"
        @touchstart="startDrawing"
        @touchend="stopDrawing"
        @touchmove="draw"
      ></canvas>
      <div class="mt-1">
        <button
          @click="clearCanvas"
          class="px-3 py-1.5 bg-gray-500 text-white rounded-lg text-xs"
        >
          Clear
        </button>
        <button
          @click="saveSignature"
          class="px-3 py-1.5 bg-green-400 text-white rounded-lg ml-2 text-xs"
        >
          Save
        </button>
      </div>
    </div>
    <img
    v-if="data"
      class="bg-white border rounded-lg w-full h-40 mt-2"
      :src="data"
      alt="signature"
    />
  </div>
</template>

<script>
import { data } from "autoprefixer";

export default {
  data() {
    return {
      isDrawing: false,
      context: null,
    };
  },
  mounted() {
    const canvas = this.$refs.signatureCanvas;
    this.context = canvas.getContext("2d");
    this.context.lineWidth = 2;
    this.context.lineCap = "round";
    this.context.strokeStyle = "#000";
  },
  methods: {
    startDrawing(event) {
      this.isDrawing = true;
      this.context.beginPath();
      this.context.moveTo(this.getX(event), this.getY(event));
    },
    stopDrawing() {
      this.isDrawing = false;
    },
    draw(event) {
      if (!this.isDrawing) return;
      this.context.lineTo(this.getX(event), this.getY(event));
      this.context.stroke();
    },
    getX(event) {
      const rect = this.$refs.signatureCanvas.getBoundingClientRect();
      return (event.clientX || event.touches[0].clientX) - rect.left;
    },
    getY(event) {
      const rect = this.$refs.signatureCanvas.getBoundingClientRect();
      return (event.clientY || event.touches[0].clientY) - rect.top;
    },
    clearCanvas() {
      const canvas = this.$refs.signatureCanvas;
      this.context.clearRect(0, 0, canvas.width, canvas.height);
    },
    async saveSignature() {
      const canvas = this.$refs.signatureCanvas;
      const dataUrl = canvas.toDataURL("image/png");
      const blob = this.dataURLToBlob(dataUrl);
      const formData = new FormData();
      formData.append("file", blob, "signature.png");

      try {
        const response = await this.$store.dispatch("sendData", {
          url: "api/file/upload",
          data: formData,
        });
        this.setData(response["file_path"]);
        alert(response["response"]);
      } catch (error) {
        console.error(error);
        alert("Upload failed.");
      }
    },
    dataURLToBlob(dataUrl) {
      const arr = dataUrl.split(",");
      const mime = arr[0].match(/:(.*?);/)[1];
      const bstr = atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new Blob([u8arr], { type: mime });
    },
  },
  props: ["setData", "data"],
};
</script>

<style>
canvas {
  touch-action: none; /* Disable touch scrolling on canvas */
}
</style>
