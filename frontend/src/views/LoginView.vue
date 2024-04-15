<script setup>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';

import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const toast = useToast();
const router = useRouter();
const form = reactive({
  email: '',
  password: '',
});
const loading = ref(false);

const formClear = () => {
  form.email = '',
  form.password = ''
}

const register = () => {
  router.push('/register');
}

const submitLogin = () => {
  loading.value = true;
  axios.post('/api/login', form)
  .then((res) => {
    localStorage.setItem('token', res.data.token);
    toast.add({ severity: 'success', summary: 'Success Message', detail: 'Login Succes', life: 3000 });
    loading.value = false;
    formClear();

    setTimeout(() => {
      router.push({
        path: '/'
      });
    }, 700);
  })
  .catch((err) => {
    toast.add({ severity: 'error', summary: 'Error Message', detail: err.response.data.message, life: 3000 });
    loading.value = false;
    formClear();
  });
}

</script>

<template>
  <div class="flex relative justify-content-center" style="top: 100px;">
      <div id="main" class="p-3 card">
          <Toast/>
          <div class="text-center mb-5 mt-3">
              <span class="text-2xl font-bold">Sign in to continue</span>
          </div>

          <form @submit.prevent="submitLogin">
              <InputText 
              type="text" 
              placeholder="Email" 
              class="w-full mb-3" 
              v-model="form.email" 
              style="padding: 10px;"/>

              <InputText 
              type="password"
              v-model="form.password" 
              placeholder="Password" 
              class="w-full mb-3" 
              inputClass="w-full"
              />

              <Button type="submit" :loading="loading" label="Sign In" class="w-full text-md" style="padding: 10px;"></Button>
              <div class="flex items-center justify-content-center mt-3">
                Didn't have account?
                  <a @click="register" class="font-medium no-underline ml-2 text-right cursor-pointer" style="color: var(--primary-color)">Register</a>
              </div>
          </form>
      </div>
  </div>
</template>

<style scoped>

@media only screen and (max-width: 600px) {
  #main {
      width: 450px;
  }
}


@media only screen and (min-width: 601px) and (max-width: 1024px) {
  #main {
      width: 500px;
  }
}

@media only screen and (min-width: 1025px) {
  #main {
      width: 500px;
  }
}
</style>