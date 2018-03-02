<div  v-show="message.visible" :class="'AlertMsg m-b-20 alert alert-'+message.type ">
    <ul>
        <li v-for="msg in message.text">@{{msg}}</li>
    </ul>
</div>