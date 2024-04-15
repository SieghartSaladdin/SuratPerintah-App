<script setup>
import Button from 'primevue/button';
import { ref, getCurrentInstance, defineProps, onMounted } from 'vue';
import FileUpload from 'primevue/fileupload';

const refInputFile = ref(null);
const selectedImage = ref(null);
const props = defineProps(['getImage']);

const { emit } = getCurrentInstance(); // Get the emit function

const openInputFile = () => {
  refInputFile.value.click();
}

const handleFileChange = () => {
  const fileInput = refInputFile.value;
  if (fileInput.files.length > 0) {
    const selectedFile = fileInput.files[0];
    // Assuming the selected file is an image, you can display it
    selectedImage.value = URL.createObjectURL(selectedFile);

    fileInput.value = null;
    // Emitting an event with the selected image
    emit('update:selectedImage', selectedFile);
  }
}

const deleteFile = () => {
  selectedImage.value = null;
  // Emitting an event with null to signify deletion
  emit('update:selectedImage', null);
}

onMounted(() => {
  selectedImage.value = props.getImage;
})
</script>

<template>
  <FileUpload>
    <template #header>
      <Button @click="openInputFile" label="Upload" icon="pi pi-plus"/>
      <input ref="refInputFile" @change="handleFileChange" type="file" style="display: none;">
      <Button :disabled="!selectedImage" @click="deleteFile" label="delete" class="p-button-danger" icon="pi pi-trash"/>
    </template>
    
    <template #content>
      <div v-if="selectedImage" style="display: flex; align-items: center; justify-content: space-between;">
        <img :src="selectedImage" alt="Selected Image" style="width: 100px; height: 100px;">
      </div>
    </template>
  </FileUpload>
</template>
