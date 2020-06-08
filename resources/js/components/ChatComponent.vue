<template>
    <div class="chat">
         <div class="class-group">
           <textarea rows="6" readonly="" class="form-control" v-model="dataMessages"></textarea>
       </div>
       <div class="input-group mb-3">
           <input type="text" class="form-control" placeholder="Write a message ... " v-model="message">
           <div class="input-group-append">
               <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Send</button>
           </div>
       </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dataMessages: [],
            message: ''
        }
    },
    mounted() {
       var socket = io('http://chat.test:3000');
        let vm = this;
        socket.on("news-action:App\\Events\\NewMessage", function(data) {
            console.log(data.message)
            vm.dataMessages.push(data.message+'\n');
        });
    },
    methods: {
        sendMessage(){
            axios({
                method: 'get',
                url: '/start/send-message',
                params: {message: this.message}
            })
            .then ((response) => {
                this.message = '';
            })
        }
    }
}
</script>