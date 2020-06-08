<template>
    <div class="chat">
        <div class="row form-group">
            <div class="col-sm">
                <select multiple="" class="form-control" v-model="usersSelect">
                    <option v-for="user in users"
                            :key="user.id"
                            :value="'user.' + user.id"
                    > {{user.email}} </option>
                </select>
            </div>
            <div class="col-sm-12">
                <textarea rows="6" readonly="" class="form-control" v-model="dataMessages"></textarea>
            </div>
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
    props: [
        'users',
        'user'
    ],
    data() {
        return {
            dataMessages: [],
            message: '',
            usersSelect: []
        }
    },
    mounted() {
       var socket = io('http://chat.test:3000');
        let vm = this;
        socket.on("user."+this.user.id +":App\\Events\\PrivateMessage", function(data) {
            console.log(data.message)
            vm.dataMessages.push(data.message.user + ': ' +  data.message.message +' \n');
        });

        socket.on("user.:App\\Events\\PrivateMessage", function(data) {
            console.log(data.message)
            vm.dataMessages.push(data.message.user + ': ' +  data.message.message +' \n');
        });
    },
    methods: {
        sendMessage(){
            if (!this.usersSelect.length)
                this.usersSelect.push('user.');
            axios({
                method: 'get',
                url: '/home/send-private-msg',
                params: { channels: this.usersSelect, message: this.message, user: this.user.email }
            })
            .then ((response) => {
                this.dataMessages.push(this.user.email + ': ' + this.message);
                this.message = '';
            })
        }
    }
}
</script>