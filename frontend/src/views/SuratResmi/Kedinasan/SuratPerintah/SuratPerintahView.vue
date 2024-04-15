<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import axios from 'axios';
import _ from 'lodash';

import Toolbar from 'primevue/toolbar';
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Dropdown from 'primevue/dropdown';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Dialog from 'primevue/dialog';
import Textarea from 'primevue/textarea';

const toast = useToast();
const token = localStorage.getItem('token');

// Menampilkan Surat
const dataSurat = ref([]);
const searchGlobal = ref('');

const formattDataChange = () => {
  if (Object.keys(selectedFormatt.value.suratperintah).length > 0) {
    // Jika memiliki data, tambahkan ke dalam dataSurat
    dataSurat.value = selectedFormatt.value.suratperintah
    formSurat.value.formatt_surat_perintahs_id = null;
    formSurat.value.formatt_surat_perintahs2_id = null;
    
    if(selectedOptionFormatt.value.is === 'sp-1') {
        formSurat.value.formatt_surat_perintahs_id = selectedFormatt.value.id
        console.log(formSurat.value)
    } else if(selectedOptionFormatt.value.is === 'sp-2') {
        console.log(formSurat.value)
        formSurat.value.formatt_surat_perintahs2_id = selectedFormatt.value.id
    } else {
        console.log('kocak');
    }
  } else {
    formSurat.value.formatt_surat_perintahs_id = null;
    formSurat.value.formatt_surat_perintahs2_id = null;

    if(selectedOptionFormatt.value.is === 'sp-1') {
        formSurat.value.formatt_surat_perintahs_id = selectedFormatt.value.id
        console.log(formSurat.value)
    } else if(selectedOptionFormatt.value.is === 'sp-2') {
        console.log(formSurat.value)
        formSurat.value.formatt_surat_perintahs2_id = selectedFormatt.value.id
    } else {
        console.log('kocak');
    }

    console.log(selectedFormatt.value);
    dataSurat.value = [];
    toast.add({ severity: 'warn', summary: 'Warning Message', detail: 'Tidak Ada Data Surat, Silahkan Buat Yang baru', life: 3000 });
  }
};


const filteredSurat = computed(() => {
    const search = searchGlobal.value.toLowerCase();
    return dataSurat.value.filter(data => {
        const no_sp = data.no_sp.toString(); // Konversi Big Integer menjadi string
        const dari = data.dari.toLowerCase(); // Konversi Big Integer menjadi string
        const bidang = data.bidang.toLowerCase(); // Pastikan bidang adalah string
        return no_sp.includes(search) || dari.includes(search) || bidang.includes(search);
    });
});


// Ambil Data Formatt Surat


const formattOption = ref([
    { name: 'Formatt Sp-1', code: '/api/data-formatt-sp-1', is: 'sp-1' },
    { name: 'Formatt Sp-2', code: '/api/data-formatt-sp-2', is: 'sp-2' },
]);

const selectedOptionFormatt = ref({});
const isOptionFormatt = ref(true);
const formattData = ref([]);
const selectedFormatt = ref({});

const formattOptionChange =  () => {
  if (selectedOptionFormatt.value.code) {
    axios.get(`${selectedOptionFormatt.value.code}`,{
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json'
        }
    })
    .then((res) => {
       console.log(res.data.formatt);
       formattData.value = res.data.formatt;
       dataSurat.value = [];
       selectedFormatt.value = {};
       isOptionFormatt.value = false;
    })
    .catch((err) => {
        console.error(err);
       isOptionFormatt.value = false;
    })
  }
};

// Membuat && Edit Surat

const dialogTitle = computed(() => {
    if (isEditMode.value) {
     return `Edit Surat, Untuk: ${selectedOptionFormatt.value.name} Id Formatt ${selectedFormatt.value.id}`;
    } else {
    return `Create Surat, Untuk: ${selectedOptionFormatt.value.name} Id Formatt ${selectedFormatt.value.id}`;
    }
});

const dialogSurat = ref(false);
const isEditMode = ref(false);
const formSurat = ref({
    no_sp: null,
    tanggal: '',
    bidang: '',
    dari: '',
    dasar: [
        { kegiatan: '' },
    ],
    kepada: [
        { name: '', nip: null, pangkat: '', jabatan: '' },
    ],
    tujuan: [
        { untuk: '' },
    ],
    untuk2: {
        untuk: '',
        lamaperjalanan: '',
        biayaperjalanan: '',
    },
    disampaikan: [
        {nama: ''},
    ],
    formatt_surat_perintahs_id: null,
    formatt_surat_perintahs2_id: null
});

const clearFormSurat = () => {
    formSurat.value.no_sp = null;
    formSurat.value.tanggal = '';
    formSurat.value.bidang = '';
    formSurat.value.dari = '';
    
    formSurat.value.dasar = [{ kegiatan: '' },];
    // Clear kepada object
    formSurat.value.kepada = [{ name: '', nip: null, pangkat: '', jabatan: '' },];

    // Clear tujuan object
    if (selectedOptionFormatt.value.is === 'sp-1') {
        formSurat.value.tujuan = [{ untuk: '' },];
    }

    // Clear untuk2 object
    if (selectedOptionFormatt.value.is === 'sp-2') {
        formSurat.value.untuk2 = { untuk: '', lamaperjalanan: '', biayaperjalanan: '' };
    }

    // Clear disampaikan object
    if (selectedOptionFormatt.value.is === 'sp-2') {
        formSurat.value.disampaikan = [{ nama: '' },];
    }
};


const createSurat = () => {
    dialogSurat.value = true;
    isEditMode.value = false;
    clearFormSurat();
}

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

const refreshDataSurat =  () => {
    if(selectedOptionFormatt.value.is === 'sp-1') {
        axios.get(`/api/data-formatt-sp-1-${selectedFormatt.value.id}`,{
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        })
        .then((res) => {
        console.log(res.data.formatt);
        dataSurat.value = res.data.formatt.suratperintah;
        })
        .catch((err) => {
            console.error(err);
        isOptionFormatt.value = false;
        })
    } else if (selectedOptionFormatt.value.is === 'sp-2') {
        axios.get(`/api/data-formatt-sp-2-${selectedFormatt.value.id}`,{
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        })
        .then((res) => {
        console.log(res.data.formatt);
        dataSurat.value = res.data.formatt.suratperintah;
        })
        .catch((err) => {
            console.error(err);
        isOptionFormatt.value = false;
        })
    }
}

const saveSurat = () => {
    const formDataToSend = { ...formSurat.value };

    if (isEmpty(formSurat.value.untuk2)) {
        delete formDataToSend.untuk2;
    }

    if (isEmpty(formSurat.value.tujuan)) {
        delete formDataToSend.tujuan;
    }

    if (isEmpty(formSurat.value.disampaikan)) {
        delete formDataToSend.disampaikan;
    }

    if(isEditMode.value == true) {
        axios.post(`/api/surat-perintah-${formSurat.value.id}`, formDataToSend, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        })
        .then((res) => {
            console.log(res);
            hideDialog();

            refreshDataSurat();
            toast.add({ severity: 'success', summary: 'Success Message', detail: 'Surat telah Berhasil Di Edit', life: 3000 });
        })
        .catch((err) => {
            console.error(err);
            console.log(formSurat.value)
        })
    } else {
        axios.post('/api/surat-perintah', formDataToSend, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        })
        .then((res) => {
            console.log(res);
            hideDialog();

            refreshDataSurat();
            toast.add({ severity: 'success', summary: 'Success Message', detail: 'Surat telah Berhasil Di Buat', life: 3000 });
        })
        .catch((err) => {
            console.error(err);
            console.log(formSurat.value)
        })
    }
}

const hideDialog = () => {
    dialogSurat.value = false;
    isEditMode.value = false;
}

const editSurat = (data) => {
    const clonedData = JSON.parse(JSON.stringify(data));
    formSurat.value = clonedData;
    dialogSurat.value = true;
    isEditMode.value = true;
}

const addTujuan = () => {
    formSurat.value.tujuan.push({untuk: ''},)
}

const removeTujuan = (index) => {
    formSurat.value.tujuan.splice(index ,1)
}

const addDasar = () => {
    formSurat.value.dasar.push({kegiatan: ''},)
}

const removeDasar = (index) => {
    formSurat.value.dasar.splice(index ,1)
}

const addKepada = () => {
    formSurat.value.kepada.push({name: '', nip: '', pangkat: '', jabatan: '',});
}

const removeKepada = (index) => {
    formSurat.value.kepada.splice(index ,1);
}

const addDisampaikan = () => {
    formSurat.value.disampaikan.push({nama: ''},)
}

const removeDisampaikan = (index) => {
    formSurat.value.disampaikan.splice(index ,1)
}

// Delete Surat

const displayConfirmation = ref(false);

const closeDelete = () => {
    displayConfirmation.value = false;
}
const openDelete = (data) => {
    const clonedData = JSON.parse(JSON.stringify(data));
    formSurat.value = clonedData;
    displayConfirmation.value = true;
}
const deleteSurat = () => {
    axios.delete(`/api/surat-perintah-${formSurat.value.id}`, {
        headers: {
            Authorization: `Bearer ${token}`,
            Accept: 'application/json'
        }
    })
    .then((res) => {
        closeDelete();
        refreshDataSurat();
        toast.add({ severity: 'success', summary: 'Success Message', detail: 'Surat telah Berhasil Di Delete', life: 3000 });
    })
    .catch((err) => {
        console.error(err)
    })
}

// View Surat
const viewSp = ref(null);
const dialogViewSurat = ref(false);
const openDetail = (data) => {
    const clonedData = JSON.parse(JSON.stringify(data));
    formSurat.value = clonedData;
    if (selectedOptionFormatt.value.is === 'sp-1') {
        axios.get(`/api/view-sp-${formSurat.value.id}-suratperintah`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            viewSp.value = response.data;
            dialogViewSurat.value = true
        })
        .catch(err => {
            // Handle the error
            console.error(err);
        });
    } else if (selectedOptionFormatt.value.is === 'sp-2') {
        axios.get(`/api/view-sp-${formSurat.value.id}-suratperintah2`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            viewSp.value = response.data;
            dialogViewSurat.value = true
        })
        .catch(err => {
            // Handle the error
            console.error(err);
        });
    }
}
// Download Surat

const downloadSurat = () => {
    if(selectedOptionFormatt.value.is === 'sp-1') {
        axios({
            url: `/api/cetak-sp-${formSurat.value.id}-suratperintah1`,
            method: 'POST',
            responseType: 'blob', // Indikasikan bahwa respons adalah sebuah blob (file)
            headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            },
        })
            .then(response => {
            // Membuat objek URL dari blob
            const url = window.URL.createObjectURL(new Blob([response.data]));
            
            // Membuat link <a> sementara untuk di-klik otomatis
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', formSurat.value.id + formSurat.value.dari + '.pdf'); // Ganti 'nama_file.pdf' sesuai nama file yang diinginkan
            document.body.appendChild(link);
            
            // Klik link untuk mengunduh file
            link.click();
            
            // Hapus link setelah selesai
            document.body.removeChild(link);
            })
            .catch(err => {
            // Handle the error
            console.error(err);
        });
    } else if(selectedOptionFormatt.value.is === 'sp-2') {
        axios({
            url: `/api/cetak-sp-${formSurat.value.id}-suratperintah2`,
            method: 'POST',
            responseType: 'blob', // Indikasikan bahwa respons adalah sebuah blob (file)
            headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            },
        })
            .then(response => {
            // Membuat objek URL dari blob
            const url = window.URL.createObjectURL(new Blob([response.data]));
            
            // Membuat link <a> sementara untuk di-klik otomatis
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', formSurat.value.id + formSurat.value.dari + '.pdf'); // Ganti 'nama_file.pdf' sesuai nama file yang diinginkan
            document.body.appendChild(link);
            
            // Klik link untuk mengunduh file
            link.click();
            
            // Hapus link setelah selesai
            document.body.removeChild(link);
            })
            .catch(err => {
            // Handle the error
            console.error(err);
        });
    }
}

// Export Data SuratPerintah

const dt = ref(null);

const exportCSV = () => {
    dt.value.exportCSV();
};

// View Formatt

const viewFormatt = ref(false)
const handleViewFormatt = () => {
    viewFormatt.value = true
}
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

</script>

<template>
    <div class="grid">
        <div class="col-12">
            <Toast/>
            <div class="card">
                <Toolbar class="mb-4">
                        <template #start>
                            <div>
                                <Dropdown style="margin: 5px;" v-model="selectedOptionFormatt" :options="formattOption" optionLabel="name" @change="formattOptionChange" placeholder="Pilih Option Formatt" />
                                <Button @click="handleViewFormatt" style="margin: 5px;" label="Preview Formatt" :disabled="isOptionFormatt" class="p-button-primary " />
                                <Dropdown style="margin: 5px;" v-model="selectedFormatt" :disabled="isOptionFormatt" :options="formattData" optionLabel="id" @change="formattDataChange" placeholder="Pilih Data Formatt" />
                               
                            </div>
                        </template>

                        <template #end>
                            <div>
                                <Button style="margin: 5px;" title="Create Surat" :disabled="isEmpty(selectedFormatt)" @click="createSurat" icon="pi pi-plus" class="p-button-primary" />
                                <Button  style="margin: 5px;" title="Export Surat"@click="exportCSV($event)" :disabled="!dataSurat.length > 0" icon="pi pi-upload" class="p-button-secondary" />
                            </div>
                        </template>
                </Toolbar>
                <DataTable v-if="dataSurat.length > 0" ref="dt" paginator :value="filteredSurat" showGridlines  :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" tableStyle="min-width: 50rem">
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Manage Surat Perintah</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="searchGlobal" placeholder="Search..." />
                            </span>
                        </div>
                    </template>
                    <Column field="no_sp" header="No_Sp" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.no_sp }}
                        </template>
                    </Column>
                    <Column field="dari" header="Dari" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.dari }}
                        </template>
                    </Column>
                    <Column field="bidang" header="Bidang" style="width: 15%;">
                        <template #body="{ data }">
                            {{ data.bidang }}
                        </template>
                    </Column>

                    <Column field="action" header="Action" style="width: 15%;">
                        <template #body="{ data }">
                                <Button icon="pi pi-pencil" title="Edit Surat" class="p-button-primary mr-2" @click="editSurat(data)" />
                                <Button icon="pi pi-search" title="View Surat" class="p-button-primary mr-2" @click="openDetail(data)" />
                                <Button icon="pi pi-trash" title="Delete Surat" class="p-button-danger" @click="openDelete(data)" />
                        </template>
                    </Column>
                </DataTable>

                <div class="text-center" v-else>
                    Pilih Formatt option Dan Data Formatt
                </div>

                <Dialog :header="headerFormatt" v-model:visible="viewFormatt" :style="{ width: '600px' }" :modal="true">
                    <img :src="imageFormatt" style="width: 550px; height: 800px; object-fit: cover;">
                </Dialog>

                <Dialog v-model:visible="dialogSurat" :style="{ width: '800px' }" :modal="true" class="p-fluid">
                    <template #header>      
                        <Button @click="handleViewFormatt" style="width: 150px; height: 50px;" label="Contoh Formatt" :disabled="isOptionFormatt" class="p-button-primary" />
                        <h5>
                            {{ dialogTitle }}
                        </h5>
                    </template>
                    <div class="p-fluid formgrid grid">
                        <div class="field col-12 md:col-6">
                            <label for="no_sp">No_Sp :</label>
                            <InputText id="no_sp" v-model="formSurat.no_sp" placeholder="Contoh: 123" type="number" />
                        </div>

                        <div class="field col-12 md:col-3">
                            <label for="dari">Bidang :</label>
                            <InputText v-model="formSurat.bidang" placeholder="Contoh: 1.2.41.62.52"/>
                        </div>

                        <div class="field col-12 md:col-3">
                            <label for="dari">Tanggal :</label>
                            <InputText id="dari" v-model="formSurat.tanggal" type="date"/>
                        </div>

                        <div class="field col-12">
                            <label for="dari">Dari :</label>
                            <InputText id="dari" v-model="formSurat.dari" type="text" placeholder="Contoh: Sekretaris" />
                        </div>

                        <div class="field col-12 mt-2 mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 15px; font-weight: bold;" for="dasar">Dasar :</label>
                            <Button icon="pi pi-plus" style="margin: 0;" class="p-button-success p-button-sm" @click="addDasar" />
                        </div>

                        <div v-for="(item , index) in formSurat.dasar" :key="index" class="field col-12">
                            <div v-show="index == 0" class="mb-2">
                                <label for="kegiatan">Kegiatan :</label>
                            </div>
                            <Textarea id="kegiatan" v-model="item.kegiatan" rows="3" placeholder="Contoh : Dokumen Pelaksanaan Anggaran pada Badan Pengelolaan Keuangan dan Aset Daerah Provinsi Jawa Barat Nomor 5.02.01.1.06.09 SubKegiatan Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD,tanggal 12 Januari 2023, maka dengan ini :" />
                            <Button v-show="index != 0" icon="pi pi-trash" class="p-button-warning p-button-sm mt-2" @click="removeDasar(index)" />
                        </div>

                        <div class="field col-12 mt-2 mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 15px; font-weight: bold;" for="dasar">Kepada :</label>
                            <Button icon="pi pi-plus" style="margin: 0;" class="p-button-success p-button-sm" @click="addKepada" />
                        </div>

                        <div v-for="(item , index) in formSurat.kepada" :key="index" class="field col-12">
                            <div class="field">
                                <label for="">Nama :</label>
                                <InputText v-model="item.name" placeholder="Contoh : Abdul Aziz Sisha" />
                            </div>


                            <div class="field">
                                <label for="">Nip :</label>
                                <InputText v-model="item.nip" placeholder="Contoh : 1233 5123 5123123"/>
                            </div>

                            <div class="field">
                                <label for="">Pangkat :</label>
                                <InputText v-model="item.pangkat" placeholder="Contoh : Pembina Utama Madya/IV d" />
                            </div>

                            <div class="field">
                                <label for="">Jabatan :</label>
                                <InputText v-model="item.jabatan" placeholder="Contoh : Kepala Badan Pengelolaan Keuangan dan Aset Daerah" />
                            </div>
                            <Button v-show="index != 0" icon="pi pi-trash" class="p-button-warning p-button-sm mt-2" @click="removeKepada(index)" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-1'" class="field col-12 mt-2 mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 15px; font-weight: bold;" for="dasar">Tujuan :</label>
                            <Button icon="pi pi-plus" style="margin: 0;" class="p-button-success p-button-sm" @click="addTujuan" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-1'" v-for="(item , index) in formSurat.tujuan" :key="index" class="field col-12">
                            <div v-show="index == 0" class="mb-2">
                                <label for="untuk">Untuk :</label>
                            </div>
                            <Textarea id="untuk" v-model="item.untuk" rows="3" placeholder="Contoh : Melaksanakan Protokol Kesehatan Covid-19 secara disiplin dan seksama, terutama dalam penggunaan masker, jaga jarak dan penggunaan handsanitizer dalam melaksanakan tugas."/>
                            <Button v-show="index != 0" icon="pi pi-trash" class="p-button-warning p-button-sm mt-2" @click="removeTujuan(index)" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12">
                            <label for="untuk2">Untuk :</label>
                            <Textarea id="untuk2" v-model="formSurat.untuk2.untuk" type="text" placeholder="Mengikuti Pembekalan Instrumen Tim Evaluasi Pengawasan dan Penyerapan Anggaran (TEPPA) Provinsi se Indonesia yang dilaksanakan UkP-PP di Jakarta"/>
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12">
                            <label for="dari">Lama Perjalanan :</label>
                            <InputText id="dari" v-model="formSurat.untuk2.lamaperjalanan" type="text" placeholder="Contoh : Selama 3 (Tiga) Hari, terhitung mulai tanggal 14s/d 16 September 2014" />
                        </div>

                         <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12">
                            <label for="dari">Biaya Perjalanan :</label>
                            <Textarea id="dari" v-model="formSurat.untuk2.biayaperjalanan" type="text" placeholder="Contoh : DPA - SKPD Biro Bina Pembangunan Setda Prov, Sulsel Kode Rekening 5.2.2.15.02"/>
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" class="field col-12 mt-2 mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                            <label style="font-size: 15px; font-weight: bold;" for="dasar">Disampaikan :</label>
                            <Button icon="pi pi-plus" style="margin: 0;" class="p-button-success p-button-sm" @click="addDisampaikan" />
                        </div>

                        <div v-if="selectedOptionFormatt.is === 'sp-2'" v-for="(item , index) in formSurat.disampaikan" :key="index" class="field col-12">
                            <div v-show="index == 0" class="mb-2">
                                <label for="untuk">Nama :</label>
                            </div>
                            <InputText id="untuk" v-model="item.nama" placeholder="Contoh : Kepala Badan Kepegawaian Daerah Prov . Sulsel di Makassar"/>
                            <Button v-show="index != 0" icon="pi pi-trash" class="p-button-warning p-button-sm mt-2" @click="removeDisampaikan(index)" />
                        </div>
                    </div>

                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
                        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveSurat" />
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

                <Dialog v-model:visible="dialogViewSurat" :style="{width: '800px'}" header="Surat Perintah">
                    <div v-if="viewSp" class="html-content-wrapper">
                        <!-- Menggunakan v-html untuk menampilkan HTML dari API -->
                        <div v-html="viewSp"></div>
                    </div>
                    <p v-else>Loading...</p>
                    <template #footer>
                        <Button @click="downloadSurat" label="Download"/>
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>