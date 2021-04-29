<template>
    <div>
        <v-toolbar color="blue darken-3">
            <v-toolbar-side-icon @click="(event)=>this.$emit('sidebarMenu',event)"></v-toolbar-side-icon>
        </v-toolbar>
  <v-list dense>
      <!--<v-list-tile exact to="/admin">
        <v-list-tile-action>
          <v-icon>dashboard</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Dashboard</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>-->
      <v-list-group no-action v-if="user.role>=6">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>speaker_notes</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Заявки</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/applicationActive">
              <v-list-tile-action>
                  <v-icon>speaker_notes</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Заявки</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
      </v-list-group>

      <v-list-group no-action v-if="user.role>=6">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>directions_bus</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Транспорт</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/transport">
              <v-list-tile-action>
                  <v-icon>directions_bus</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Транспорт</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
      </v-list-group>
      <v-list-group no-action v-if="user.role>=3">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>receipt</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Квитки</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/ticket">
              <v-list-tile-action>
                  <v-icon>receipt</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Квитки</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
          <v-list-tile to="/ticketReport">
              <v-list-tile-action>
                  <v-icon>receipt</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Звіт</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
      </v-list-group>

      <v-list-group no-action v-if="user.role>=6">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>date_range</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Рейси</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/tripActive">
              <v-list-tile-action>
                  <v-icon>date_range</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Рейси</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
      </v-list-group>
      <v-list-group no-action v-if="user.role>=6">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>extension</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Маршрути</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/routesActive">
              <v-list-tile-action>
                  <v-icon>extension</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Маршрути</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
          <v-list-tile to="/routesRoute">
              <v-list-tile-action>
                  <v-icon>extension</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Підмаршрути</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>
      </v-list-group>

      <v-list-group no-action v-if="user.role>=2">
          <v-list-tile slot="activator">
              <v-list-tile-action>
                  <v-icon>domain</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Вакансії</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/vacancyActive" v-if="user.role>=2">
              <v-list-tile-action>
                  <v-icon>domain</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Вакансії</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

          <v-list-tile to="/vacancyCategory" v-if="user.role>=6">
              <v-list-tile-action>
                  <v-icon>account_circle</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                  <v-list-tile-title>Категорії</v-list-tile-title>
              </v-list-tile-content>
          </v-list-tile>

      </v-list-group>

    <v-list-group no-action v-if="user.role>=6">
      <v-list-tile slot="activator">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Користувачі</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

        <v-list-tile to="/clients">
            <v-list-tile-action>
                <v-icon>group</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Клієнти</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>

      <v-list-tile to="/users">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Користувачі</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <!--<v-list-tile to="/roles">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Roles</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/permissions">
        <v-list-tile-action>
          <v-icon>account_circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>Permissions</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>-->
    </v-list-group>

    <v-list-group no-action v-if="user.role>=6">
         <v-list-tile slot="activator">
             <v-list-tile-action>
                 <v-icon>map</v-icon>
             </v-list-tile-action>
             <v-list-tile-content>
                 <v-list-tile-title>Географія</v-list-tile-title>
             </v-list-tile-content>
         </v-list-tile>

         <v-list-tile to="/city">
             <v-list-tile-action>
                 <v-icon>map</v-icon>
             </v-list-tile-action>
             <v-list-tile-content>
                 <v-list-tile-title>Міста</v-list-tile-title>
             </v-list-tile-content>
         </v-list-tile>
        <v-list-tile to="/region">
            <v-list-tile-action>
                <v-icon>map</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Регіон</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile to="/country">
            <v-list-tile-action>
                <v-icon>map</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>Країни</v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
    </v-list-group>

  </v-list>
    </div>
</template>


<script>
export default {
    props:["user"]
}

</script>


