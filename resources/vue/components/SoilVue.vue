// resources/components/SoilVue.vue

<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
        <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
          <div class="card-title">
            <h5 class="text-nowrap mb-2">Soil Moisture</h5>
            <span class="badge bg-label-warning rounded-pill">Current</span>
          </div>
          <div class="mt-sm-auto">
            <h3 class="mb-0"><span id="soil">{{soilmoisture}}</span>%</h3>
          </div>
        </div>
        <div id="profileReportChart"></div>
      </div>
    </div>
  </div>
</template>

<script>
import * as mqtt from 'mqtt';
import { onMounted, ref } from 'vue';


export default {
  name: 'SoilVue',
  props: ['soilmoisture'],
  setup(){
    const data = ref("");
    onMounted(() => {
      const client = mqtt.connect('mqtt://broker.emqx.io:8083/mqtt');
  
      client.subscribe("smart_farm/dataset");
  
      client.on('message', function (topic, message) {
        data.value = message.toString();
        const d = '{'+data.value+'}';
        const jj = JSON.parse(d);
        var node = jj.nodes[1];
        node = node.split(',');

        console.log(node[3]);
        document.getElementById('soil').innerHTML=node[3];
      })    
    });
  }
}
</script>