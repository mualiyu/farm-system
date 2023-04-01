// resources/components/TempVue.vue

<template>
  <div class="card">
    <div class="card-body">
      <div class="card-title d-flex align-items-start justify-content-between">
        <div class="avatar flex-shrink-0">
          <img src="/assets/img/icons/unicons/temp.jpg" alt="chart success" class="rounded">
        </div>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <span class="fw-semibold d-block mb-1">Temp</span>
      <h3 class="card-title mb-2"><span id="temp">{{temperature}}</span><sup>o</sup>C</h3>
      <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i> +72.80%</small>
    </div>
  </div>
</template>

<script>
import * as mqtt from 'mqtt';
import { onMounted, ref } from 'vue';


export default {
  name: 'TempVue',
  props: ['temperature'],
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
        console.log(node[1]);
        document.getElementById('temp').innerHTML=node[1];
      })    
    });
  }
}
</script>