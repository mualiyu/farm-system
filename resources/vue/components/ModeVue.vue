// resources/components/ModeVue.vue

<template>
  <div class="form-check form-switch mt-3">
    <input class="form-check-input" @change="changeState(mode, pump)" type="checkbox" role="switch" id="flexSwitchCheckCheckedMode" v-if="mode == 0">
    <input class="form-check-input" @change="changeState(mode, pump)"  type="checkbox" role="switch" id="flexSwitchCheckCheckedMode" checked v-else>
    <label class="form-check-label" for="flexSwitchCheckCheckedMode">Automatic Mode</label>
  </div>
</template>

<script>
import * as mqtt from 'mqtt';
import { onMounted, ref } from 'vue';

const client = mqtt.connect('mqtt://broker.emqx.io:8083/mqtt');

export default {
  name: 'ModeVue',
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
        var mode = jj.operationMode;
        // console.log(jj);
        const modeb = document.getElementById('flexSwitchCheckCheckedMode');
        modeb.checked = mode;
        
      }) 
    });
  },
  methods:{
    changeState(mode,pump) {
        
        var m = mode==0 ? "true":"false";
        var p = pump==1 ? "true":"false";

        client.publish('smart_farm/command', '{"pump": "'+p+'", "operationMode": "'+m+'"}');
        console.log("published");
    }
  }
}
</script>