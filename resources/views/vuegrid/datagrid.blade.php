 <div class="row" id="{{ $tableId }}">
  <div class="form-inline">
    <div class="row">
      <div class="col-sm-4 table-toolbar-left">
        <h3 class="panel-title text-bold" v-if="title.length > 0" >
          @{{title}}
        </h3>
      </div>
      <div class="col-sm-8 table-toolbar-right">
          <div class="input-group" v-if="search">
              <input type="text" autocomplete="off" class="form-control" name="search" v-model="searchQuery" placeholder="{{ trans('joesama/vuegrid::datagrid.search') }}" >
              <span class="input-group-btn">
                <button class="btn btn-primary" @click.prevent="fetchItems(1)">
                  <i class="fa fa-search icon-fw"></i>
                </button>
              </span>
          </div>
          <div class="btn-group" v-if="gridNew">
            <a class="btn btn-primary" :href="gridNew" v-if="gridNewDesc">
              <i class="ion-plus-round icon-fw"></i>&nbsp;
              @{{ gridNewDesc }}
            </a>
            <a class="btn btn-dark" :href="gridNew" v-else >
              <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
              {{ trans('joesama/vuegrid::datagrid.buttons.add') }}
            </a>
          </div>
      </div>
    </div>
  </div>
  <vue-grid
    :data="gridData"
    :title="title"
    :actions = "gridActions"
    :simple = "gridActionsSimple"
    :columns="gridColumns"
    :current_page="pagination.current_page"
    :per_page="pagination.per_page"
    :filter-key="searchQuery">
  </vue-grid>
  <div class="pull-left">
    <strong>{{ trans('joesama/vuegrid::datagrid.total') }}</strong>
              &nbsp;:&nbsp;@{{ pagination.total }}
  </div>
  <div class="text-center">
    <ul class="pagination text-nowrap mar-no">
      <li class="page-pre" v-if="pagination.current_page > 1">
          <a  href="#" aria-label="Previous"
             @click.prevent="changePage(pagination.current_page - 1)">
              <span aria-hidden="true">&laquo;</span>
          </a>
      </li>
      <li class="page-pre disabled" v-if="pagination.current_page = 1">
          <a href="#">&laquo;</a>
      </li>
      <li v-for="page in pagesNumber"
          v-bind:class="[ page == isActived ? 'page-number active' : 'page-number']">
          <a class="page-link" href="#"
             @click.prevent="changePage(page)">@{{ page }}</a>
      </li>
      <li class="page-next"  v-if="pagination.current_page < pagination.last_page">
          <a class="page-link" href="#" aria-label="Next"
             @click.prevent="changePage(pagination.current_page + 1)">
              <span aria-hidden="true">&raquo;</span>
          </a>
      </li>
    </ul>
  </div>
</div>
<script type="text/x-template" id="{{ 'tpl-'.$tableId  }}">
<div class="table-responsive-md">
  <table  id="{{ 'tbl-'.$tableId }}" class="table table-sm table-borderless table-striped table-condensed table-vcenter">
    <thead>
      <tr>
        <th class="bg-dark text-light" width="20px" style="color:white" >#</th>
        <th class="bg-dark text-light" :class="key.style" style="color:white"  v-for="key in columns"
          @click="sortBy(key.field)">
          @{{ key.title | capitalize }}
          <i :class="sortOrders[key.field] > 0 ? 'pull-right fa fa-caret-down' : 'pull-right  fa fa-caret-up'">
          </i>
        </th>
        <th class="bg-dark text-light text-center" style="color:white"  v-if="actions" width="10%px">
          {{ trans('joesama/vuegrid::datagrid.actions') }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-if="filteredData.length < 1">
        <td :colspan="columns.length + 2"><p><center>{{ trans('joesama/vuegrid::datagrid.empty') }}</center></p></td>
      </tr>
      <tr v-for="(entry, index) in filteredData">

        <td class="text-center bg-white text-dark" >@{{ runner + (index + 1 ) }}</td>
        <td v-for="key in columns" v-bind:class="[ key.style ? key.style : '']">
          <a v-if="key.file" class="btn btn-primary btn-xs" :href="createUri(entry,key)" target="_blank">
            <i class="fa fa-download" aria-hidden="true"></i>&nbsp;@{{ sanitizeUri(entry,key) }}
          </a>
          <a v-if="key.uri" :href="uriaction(key.uri.url,entry[key.uri.key])" target="_blank">@{{ display(entry,key) }}</a>
          <a v-if="key.route" :href="route(display(entry,key))" target="_blank">@{{ display(entry,key) }}</a>
          <span v-if="key.iconic">
              <i v-if="display(entry,key) == 1" class="fa fa-check-circle-o fa-2x text-success" aria-hidden="true"></i>
              <i v-if="display(entry,key) == 0" class="fa fa-times fa-2x text-danger" aria-hidden="true"></i>
          </span>
          <span v-if="!key.file && !key.uri && !key.route && !key.iconic">@{{ display(entry,key) }}</span>
        </td>
        <td v-if="actions" class="text-center bg-white text-dark" >
          <!-- START BUTTON IS NOT SIMPLE -->
          <div class="btn-group" v-if="(actions.length > 1) && !simple">
            <button type="button" class="btn btn-outline-primary btn-sm font-weight-light" data-toggle="button" aria-pressed="false" autocomplete="off">{{ trans('joesama/vuegrid::datagrid.actions') }} </button>
            <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li v-for="btn in actions">
              <a :href="uriaction(btn.url,entry[btn.key])">
              <i v-bind:class="btn.icons" aria-hidden="true"></i>&nbsp;@{{ btn.action }} @{{ btn.delete }}
              </a>
              </li>
            </ul>
          </div>
          <a v-if="(actions.length < 2) && !simple" :href="uriaction(btn.url,entry[btn.key])" v-for="btn in actions" class="btn btn-sm btn-actions">
          <i v-bind:class="btn.icons" aria-hidden="true"></i>&nbsp;
          @{{ btn.action }}
          </a>
          <!-- END BUTTON IS NOT SIMPLE -->

          <!-- START BUTTON IS SIMPLE -->
          <div  v-if="simple" class="btn-group btn-group-sm" role="group" aria-label="...">
            <a :href="uriaction(btn.url,entry[btn.key])" :title="btn.action || btn.delete" v-for="btn in actions" v-bind:class="[ btn.delete ? 'btn btn-sm btn-outline-danger' : 'btn btn-outline-primary btn-sm']" v-on:click.prevent="confimAction(btn,uriaction(btn.url,entry[btn.key]))">
            <i v-bind:class="btn.icons" aria-hidden="true"></i>
            </a>
          </div>
          <!-- END BUTTON IS SIMPLE -->
        </td>
      </tr>
    </tbody>
  </table>
</div>
</script>

