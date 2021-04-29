<template>
  <div id="app">
    <v-app id="inspire" dark>

        <v-navigation-drawer
            v-model="sidebarMenu"
            app
        >
        <sidebar
            v-on:sidebarMenu="updateSM"
            :user="user"
        ></sidebar>
      </v-navigation-drawer>

      <navbar v-on:sidebarMenu="updateSM" :user="user"></navbar>

      <v-content color="red">
        <v-container fluid fill-height>
          <v-layout justify-center>
            <v-flex shrink>
              <router-view></router-view>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
      <v-footer app absolute>
        <span>&copy; 2020</span>
      </v-footer>
    </v-app>
  </div>
</template>

<script>
import Sidebar from "./_sidebar";
import Navbar from "./_navbar";
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

Vue.component('vue-phone-number-input', VuePhoneNumberInput);
export default {
  components: { Sidebar, Navbar },
  data: () => ({
      sidebarMenu: false
  }),
  methods:{
      updateSM(){
          this.sidebarMenu=!this.sidebarMenu
      }
  },
  computed: {
       mini() {
           return (this.$vuetify.breakpoint.smAndDown) || this.toggleMini
       },
  },
  props: ["user"]
};
</script>
