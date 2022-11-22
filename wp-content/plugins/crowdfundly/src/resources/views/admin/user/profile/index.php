<div id="profile">
    <h1 v-text="mesage"></h1>
</div>

<script>
    let app = new Vue({
        el: '#profile',
        data() {
            return {
                mesage: 'This is a message;'
            }
        },
    })
</script>