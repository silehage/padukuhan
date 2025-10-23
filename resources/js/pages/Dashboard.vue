<script setup>
import UsiaBarCharts from '@/components/charts/UsiaBarCharts.vue';
import UsiaPieCharts from '@/components/charts/UsiaPieCharts.vue';

defineProps(['data'])

</script>


<template>
   <AppHeader title=Dashboard></AppHeader>
   <div class="grid grid-cols-2 gap-4">
        <q-card class="section">
         <q-card-section>
            <!-- <div class="grid-cols-2">
               <q-item-section>
                  <q-avatar rounded size="3rem" icon="groups" color="pink" text-color="white"></q-avatar>
               </q-item-section>
               <q-item-section>
                  <div class="text-md">Jumlah Kartu Keluarga</div>
                  <div class="text-lg">{{ data.total_kk }} KK</div>
               </q-item-section>
            </div> -->
            <q-list>
               <q-item>
                  <q-item-section avatar>
                     <q-avatar rounded size="3rem" icon="groups" color="pink" text-color="white"></q-avatar>
                  </q-item-section>
                  <q-item-section>
                     <div class="text-weight-medium">Jumlah Kartu Keluarga</div>
                     <div class="text-lg">{{ data.total_kk }} KK</div>
                  </q-item-section>
               </q-item>
            </q-list>
         </q-card-section>
      </q-card>
      <q-card class="section">
         <q-card-section>
            <q-list>
               <q-item>
                  <q-item-section avatar>
                     <q-avatar rounded size="3rem" icon="account_box" color="purple" text-color="white"></q-avatar>
                  </q-item-section>
                  <q-item-section>
                     <div class="text-weight-medium">Jumlah Penduduk</div>
                     <div class="text-lg">{{ data.total_warga }} Orang</div>
                  </q-item-section>
               </q-item>
            </q-list>
         </q-card-section>
      </q-card>
   </div>
   <div class="flex gap-4 q-mt-lg">
      <q-card class="section flex-1">
         <q-card-section>
            <UsiaBarCharts></UsiaBarCharts>
         </q-card-section>
      </q-card>
      <q-card class="section">
         <q-card-section>
            <UsiaPieCharts></UsiaPieCharts>
         </q-card-section>
      </q-card>

   </div>

</template>
