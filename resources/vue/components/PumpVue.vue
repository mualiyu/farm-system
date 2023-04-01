// resources/components/PumpVue.vue

<template>
  <div class="form-check form-switch">
    <input class="form-check-input" @change="changeState(mode, pump)" type="checkbox" role="switchf" id="flexSwitchCheckCheckedPump" v-if="pump == 0">
    <input class="form-check-input" @change="changeState(mode, pump)"  type="checkbox" role="switchf" id="flexSwitchCheckCheckedPump" checked v-else>
    <label class="form-check-label" for="flexSwitchCheckCheckedPump">Water Pump</label>
  </div>
</template>

<script>
import * as mqtt from 'mqtt';
import { onMounted, ref } from 'vue';

const client = mqtt.connect('mqtt://broker.emqx.io:8083/mqtt');

export default {
  name: 'PumpVue',
  props: ['device_id', 'mode', 'pump'],
  setup(){
    const data = ref("");
    onMounted(() => {
  
      client.subscribe("smart_farm/dataset");
  
      client.on('message', function (topic, message) {
        data.value = message.toString();
        const d = '{'+data.value+'}';
        const jj = JSON.parse(d);
        var device = jj.device_id;
        var pump = jj.pump;
        console.log(pump);
        const pumpp = document.getElementById('flexSwitchCheckCheckedPump');
        pumpp.checked = pump;
        
      }) 
    });
  },
  methods:{
    changeState(mode,pump) {
        
        var m = mode==1 ? "true":"false";
        var p = pump==0 ? "true":"false";

        client.publish('smart_farm/command', '{"pump": "'+p+'", "operationMode": "'+m+'"}');
        console.log("published");
    }
  }
}
</script>