<style>
    .outline-none {
        outline:none !important;
        outline-width: 0 !important;
        box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
    }
</style>
<template>
    <div class="relative h-10 m-1">
        <div style="border-top: 1px solid #e6e6e6;" class="grid grid-cols-6">
            <input
                type="text"
                v-model="message"
                @keyup.enter="sendMessage()"
                placeholder="Say something..."
                class="outline-none col-span-5 p-1"
                />
            <button
                @click="sendMessage()"
                class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white">
                Send
            </button>
        </div>
    </div>
</template>

<script>
import Input from '../../Jetstream/Input.vue';

export default {
    components: { Input },
    props: ['room'],
    data: function() {
        return {
            message: ''
        }
    },
    methods: {
        sendMessage() {
            if(this.message==' '){
                return;
            }

            axios.post('/chat/room/'+this.room.id+'/messages',{
                message: this.message
            })
            .then(response=>{
                if(response.status==201) {
                    this.message = ' ',
                    this.$emit('messageSent');
                }
            })
            .catch(error=>{
                console.log(error);
            })
        }
    }
}
</script>