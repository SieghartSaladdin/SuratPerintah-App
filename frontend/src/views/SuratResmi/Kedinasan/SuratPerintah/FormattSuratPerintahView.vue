<script setup>
import { computed, ref } from 'vue'

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toolbar from 'primevue/toolbar';
import Dropdown from 'primevue/dropdown';
import axios from 'axios';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';

import FileInput from "@/components/FileInput.vue";

const toast = useToast();
const token = localStorage.getItem('token');

// Ambil Data Formatt Surat Perintah
const formattOption = ref([
    { name: 'Formatt Sp-1', code: '/api/data-formatt-sp-1', is: 'sp-1' },
    { name: 'Formatt Sp-2', code: '/api/data-formatt-sp-2', is: 'sp-2' },
]);

const dataFormatt = ref([]);
const selectedOptionFormatt = ref({});
const searchGlobal = ref('');

const getDataFormatt = () => {
    axios.get(`${selectedOptionFormatt.value.code}`, {
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json'
        }
    })
    .then((res) => {
        console.log(res);
        dataFormatt.value = res.data.formatt;
    })
    .catch((err) => {
        console.error(err);
    })
}

const filteredFormatt = computed(() => {
    const search = searchGlobal.value.toLowerCase();
    return dataFormatt.value.filter(data => {
        const id = data.id.toString(); // Konversi Big Integer menjadi string
        const judul = data.judul.toLowerCase(); // Konversi Big Integer menjadi string
        const nama_lembaga = data.nama_lembaga.toLowerCase(); // Pastikan bidang adalah string
        return nama_lembaga.includes(search) || judul.includes(search) || id.includes(search);
    });
});

// Create && Edit Formatt

const isDisabled = ref(false);
const isEditMode = ref(false);
const dialogFormatt = ref(false);
const formFormatt = ref({
    gambar: null,
    judul: '',
    nama_lembaga: '',
    alamat: '',
    kota_pos: '',
    pelaksanaan_tugas: '',
    dikeluarkan_di: '',
    ditetapkan_di: '',
    website: '',
    atas_nama: '',
    an_nama: '',
    an_pangkat: '',
    an_jabatan: '',
    an_nip: '',
});

const isEmpty = (obj) => {
  // Fungsi untuk memeriksa apakah objek kosong atau memiliki properti yang kosong
  if (Array.isArray(obj)) {
    return obj.length === 0 || obj.every(isEmpty);
  } else if (typeof obj === 'object' && obj !== null) {
    return Object.values(obj).every(value => isEmpty(value));
  } else {
    return obj === null || obj === '';
  }
};

const hideDialog = () => {
    dialogFormatt.value = false;
}

const dialogTitle = computed(() => {
    if (isEditMode.value) {
     return `Edit Surat ${selectedOptionFormatt.value.name}`;
    } else {
    return `Create Surat ${selectedOptionFormatt.value.name}`;
    }
});

const createFormatt = () => {
    isEditMode.value = false;
    dialogFormatt.value = true;
    formFormatt.value = {};
}

const saveFormatt = () => {
    const formData = new FormData();

    if (isEditMode.value == true) {
        if (selectedOptionFormatt.value.is === 'sp-1') {
            if (isEmpty(formFormatt.value.gambar)) {
                formData.append('gambar', formFormatt.value.gambar);
            }

            formData.append('judul', formFormatt.value.judul);
            formData.append('nama_lembaga', formFormatt.value.nama_lembaga);
            formData.append('alamat', formFormatt.value.alamat);
            formData.append('website', formFormatt.value.website);
            formData.append('kota_pos', formFormatt.value.kota_pos);
            formData.append('ditetapkan_di', formFormatt.value.ditetapkan_di);
            formData.append('atas_nama', formFormatt.value.atas_nama);
            formData.append('an_nama', formFormatt.value.an_nama);
            formData.append('an_jabatan', formFormatt.value.an_jabatan);
            formData.append('an_nip', formFormatt.value.an_nip);

            axios.post(`/api/update-formatt-sp-1-${formFormatt.value.id}`, formData, {
                headers : {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                hideDialog();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Update', life: 3000 });
            })
            .catch((err) => {
                console.log(err);
            })
        } else if(selectedOptionFormatt.value.is === 'sp-2') {
            if (isEmpty(formFormatt.value.gambar)) {
                formData.append('gambar', formFormatt.value.gambar);
            }

            formData.append('judul', formFormatt.value.judul);
            formData.append('nama_lembaga', formFormatt.value.nama_lembaga);
            formData.append('alamat', formFormatt.value.alamat);
            formData.append('kota_pos', formFormatt.value.kota_pos);
            formData.append('pelaksanaan_tugas', formFormatt.value.pelaksanaan_tugas);
            formData.append('dikeluarkan_di', formFormatt.value.dikeluarkan_di);
            formData.append('an_nama', formFormatt.value.an_nama);
            formData.append('an_pangkat', formFormatt.value.an_pangkat);
            formData.append('an_nip', formFormatt.value.an_nip);
            formData.append('atas_nama', formFormatt.value.atas_nama);

            axios.post(`/api/update-formatt-sp-2-${formFormatt.value.id}`, formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                console.log(res);
                hideDialog();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Edit', life: 3000 });
            })
            .catch((err) => {
                console.error(err);
                console.log(formDataToSend)
                console.log(formFormatt.value)
            })
        }
    } else {
        if (selectedOptionFormatt.value.is === 'sp-1') {
            formData.append('gambar', formFormatt.value.gambar);
            formData.append('judul', formFormatt.value.judul);
            formData.append('nama_lembaga', formFormatt.value.nama_lembaga);
            formData.append('alamat', formFormatt.value.alamat);
            formData.append('website', formFormatt.value.website);
            formData.append('kota_pos', formFormatt.value.kota_pos);
            formData.append('ditetapkan_di', formFormatt.value.ditetapkan_di);
            formData.append('atas_nama', formFormatt.value.atas_nama);
            formData.append('an_nama', formFormatt.value.an_nama);
            formData.append('an_jabatan', formFormatt.value.an_jabatan);
            formData.append('an_nip', formFormatt.value.an_nip);

            axios.post('/api/create-formatt-sp-1', formData, {
                headers : {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                console.log(res);
                hideDialog();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Create', life: 3000 });
            })
            .catch((err) => {
                console.error(err);
            })
        } else if (selectedOptionFormatt.value.is === 'sp-2') {
            formData.append('gambar', formFormatt.value.gambar);
            formData.append('judul', formFormatt.value.judul);
            formData.append('nama_lembaga', formFormatt.value.nama_lembaga);
            formData.append('alamat', formFormatt.value.alamat);
            formData.append('kota_pos', formFormatt.value.kota_pos);
            formData.append('pelaksanaan_tugas', formFormatt.value.pelaksanaan_tugas);
            formData.append('dikeluarkan_di', formFormatt.value.dikeluarkan_di);
            formData.append('an_nama', formFormatt.value.an_nama);
            formData.append('an_pangkat', formFormatt.value.an_pangkat);
            formData.append('an_nip', formFormatt.value.an_nip);
            formData.append('atas_nama', formFormatt.value.atas_nama);

            axios.post('/api/create-formatt-sp-2', formData, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                console.log(res);
                hideDialog();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Edit', life: 3000 });
            })
            .catch((err) => {
                console.error(err);
                console.log(formDataToSend)
                console.log(formFormatt.value)
            })
        }
    }
}

const getImage = computed(() => {
  if (isEditMode.value == true) {
    return `http://localhost:8000/uploads/${formFormatt.value.gambar}`
  } else {
    return null
  }
});

const handleSelectedImageUpdate = (updatedImage) => {
    formFormatt.value.gambar = updatedImage;
    console.log(updatedImage);
}

const editFormatt = (data) => {
    formFormatt.value = data;
    dialogFormatt.value = true;
    isEditMode.value = true;
}

// Delete Surat

const displayConfirmation = ref(false);

const openDelete = (data) => {
    displayConfirmation.value = true;
    formFormatt.value = data;
}

const closeDelete = () => {
    displayConfirmation.value = false;
}

const deleteSurat = () => {
    if (selectedOptionFormatt.value.is === 'sp-1') {
        axios.delete(`/api/delete-formatt-sp-1-${formFormatt.value.id}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                console.log(res);
                closeDelete();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Delete', life: 3000 });
            })
            .catch((err) => {
                console.error(err);
                console.log(formFormatt.value)
            })
    } else if (selectedOptionFormatt.value.is === 'sp-2') {
        axios.delete(`/api/delete-formatt-sp-2-${formFormatt.value.id}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            })
            .then((res) => {
                console.log(res);
                closeDelete();

                getDataFormatt();
                toast.add({ severity: 'success', summary: 'Success Message', detail: 'Formatt telah Berhasil Di Delete', life: 3000 });
            })
            .catch((err) => {
                console.error(err);
                console.log(formDataToSend)
                console.log(formFormatt.value)
            })
    }
}

// Export data formatt

const dt = ref(null);

const exportCSV = () => {
    dt.value.exportCSV();
};

// Menampilkan Preview Image

const headerFormatt = computed(() => {
    if (selectedOptionFormatt.value.is === 'sp-1') {
     return `Contoh Formatt Sp-1`;
    } else if(selectedOptionFormatt.value.is === 'sp-2') {
    return `Contoh Formatt Sp-2`;
    }
});

const imageFormatt = computed(() => {
    if (selectedOptionFormatt.value.is === 'sp-1') {
     return `/public/image/Gambar.png`;
    } else if(selectedOptionFormatt.value.is === 'sp-2') {
    return `/public/image/Mamamia.png`;
    }
}); 

const viewFormatt = ref(false);
const previewFormatt = () => {
    viewFormatt.value = true;
}

</script>

<template>
    <div class="grid">
        <div class="col-12">
            <Toast/>
            <div class="card">
                <Toolbar class="mb-4">
                        <template #start>
                            <div>
                                <Dropdown style="margin:  5px;" :options="formattOption" optionLabel="name" v-model="selectedOptionFormatt" @change="getDataFormatt" placeholder="Pilih Option Formatt"/>
                                <Button style="margin: 5px;" @click="previewFormatt"  :disabled="isEmpty(selectedOptionFormatt)" label="Preview Formatt"/>
                            </div>
                        </template>

                        <template #end>
                            <div>
                                <Button style="margin: 5px;" title="Create Formatt" :disabled="isEmpty(selectedOptionFormatt)" @click="createFormatt" icon="pi pi-plus" class="p-button-primary"/>
                                <Button style="margin: 5px;" title="Export formatt" :disabled="!dataFormatt.length > 0" @click="exportCSV($event)" icon="pi pi-upload" class="p-button-secondary"/>
                            </div>
                        </template>
                </Toolbar>

                <DataTable v-if="dataFormatt.length > 0" ref="dt" paginator :value="filteredFormatt" showGridlines  :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Manage Formatt Surat Perintah</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="searchGlobal" placeholder="Search..." />
                            </span>
                        </div>
                    </template>

                    <Column field="id" header="Id" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.id }}
                        </template>
                    </Column>

                    <Column field="judul" header="Judul" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.judul }}
                        </template>
                    </Column>

                    <Column field="subjudul" header="Nama Lembaga" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.nama_lembaga }}
                        </template>
                    </Column>

                    <Column field="action" header="Action" style="width: 15%;">
                        <template #body="{ data }">
                                <Button icon="pi pi-pencil" title="Edit Formatt" class="p-button-primary mr-2" @click="editFormatt(data)" />
                                <Button icon="pi pi-trash"title="Delete Formatt" class="p-button-danger" @click="openDelete(data)" />
                        </template>
                    </Column>
                </DataTable>

                <div v-else>
                    <p class="text-center">Pilih Option Formatt</p>
                </div>

                <Dialog :header="headerFormatt" v-model:visible="viewFormatt" :style="{ width: '600px' }" :modal="true">
                    <img :src="imageFormatt" style="width: 550px; height: 800px; object-fit: cover;">
                </Dialog>

                <Dialog v-model:visible="dialogFormatt" :style="{ width: '800px' }" :modal="true" class="p-fluid">
                    <template #header>
                        <h5><b>{{ dialogTitle }}</b></h5>
                        <Button @click="previewFormatt" style="width: 100px; height: 35px;" label="Preview Formatt"/>
                    </template>

                    <div class="p-fluid formgrid grid">
                        <div class="field col-12">
                            <label for="judul">Gambar :</label>
                            <FileInput :getImage="getImage" @update:selectedImage="handleSelectedImageUpdate" />
                        </div>

                        <div class="field col-12">
                            <label for="judul">Judul :</label>
                            <InputText id="judul" v-model="formFormatt.judul" type="text" placeholder="Contoh : PEMERINTAH DAERAH PROVINSI JAWA BARAT" />
                        </div>

                        <div class="field col-12">
                            <label for="nama_lembaga">Nama Lembaga :</label>
                            <InputText id="nama_lembaga" v-model="formFormatt.nama_lembaga" type="text" placeholder="Contoh : SEKRETARIAT DAERAH" />
                        </div>

                        <div class="field col-12">
                            <label for="alamat">Alamat :</label>
                            <InputText id="alamat" v-model="formFormatt.alamat" type="text" placeholder="Contoh : Jalan Dipenogoro Nomor 22 Telepon (022) 4232425 - 4242323 - 423123" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-1'" class="field col-12">
                            <label for="website">Website :</label>
                            <InputText id="website" v-model="formFormatt.website" type="text" placeholder="Contoh : www.jabarprov.go.id"/>
                        </div>

                        <div class="field col-12">
                            <label for="kota_pos">Kota Dan Pos :</label>
                            <InputText id="kota_pos" v-model="formFormatt.kota_pos" type="text" placeholder="Contoh : Bandung 40421" />
                        </div>

                        <div class="field col-12 md:col-6">
                            <label for="atas_nama">Atas Nama:</label>
                            <InputText id="atas_nama" v-model="formFormatt.atas_nama" type="text" placeholder="Contoh : KEPALA BADAN PENDAPATAN DAERAH PROVINSI JAWA BARAT Sekretaris," />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-1'" class="field col-12 md:col-6">
                            <label for="ditetapkan_di">Ditetapkan Di :</label>
                            <InputText id="ditetapkan_di" v-model="formFormatt.ditetapkan_di" type="text" placeholder="Contoh : Bandung" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12 md:col-6">
                            <label for="dikeluarkan_di">Dikeluarkan Di :</label>
                            <InputText id="dikeluarkan_di" v-model="formFormatt.dikeluarkan_di" type="text" placeholder="Contoh : Bandung" />
                        </div>
                        
                        <div class="field col-12 md:col-4">
                            <label for="an_nama">a.n Nama :</label>
                            <InputText id="an_nama" v-model="formFormatt.an_nama" type="text" placeholder="Contoh : Drs. H. MAJU WIJAYA, SH , M.Si" />
                        </div>
                        
                        <div v-if="selectedOptionFormatt.is === 'sp-1'" class="field col-12 md:col-4">
                            <label for="an_jabatan">a.n Jabatan :</label>
                            <InputText id="an_jabatan" v-model="formFormatt.an_jabatan" type="text" placeholder="Contoh : Pembina Utama Madya" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12 md:col-4">
                            <label for="an_pangkat">a.n Pangkat :</label>
                            <InputText id="an_pangkat" v-model="formFormatt.an_pangkat" type="text" placeholder="Contoh : Pembina Utama Madya"/>
                        </div>

                        <div class="field col-12 md:col-4">
                            <label for="an_nip">a.n Nip :</label>
                            <InputText id="an_nip" v-model="formFormatt.an_nip" type="text" placeholder="Contoh : 1231241 193312 1 002" />
                        </div>


                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12">
                            <label for="pelaksanaan_tugas">Plt :</label>
                            <InputText id="pelaksanaan_tugas" v-model="formFormatt.pelaksanaan_tugas" type="text" placeholder="Contoh : Sekretariat Daerah" />
                        </div>

                    </div>

                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
                        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveFormatt" />
                    </template>
                </Dialog>

                <Dialog header="Confirmation" v-model:visible="displayConfirmation" :style="{ width: '350px' }" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span>Are you sure you want to proceed?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" @click="closeDelete" class="p-button-text" />
                        <Button label="Yes" icon="pi pi-check" @click="deleteSurat" class="p-button-text" />
                    </template>
                </Dialog>

            </div>
        </div>
    </div>
</template>