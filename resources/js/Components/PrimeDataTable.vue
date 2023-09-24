<script setup lang="ts">
import { ref } from "vue";
import dayjs from 'dayjs/esm';
import 'dayjs/locale/id'
import { router, Link } from '@inertiajs/vue3';
import DataTable, { DataTableFilterMeta, DataTableFilterEvent, DataTableSortEvent, DataTablePageEvent, DataTableSortMeta} from "primevue/datatable";
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Calendar from 'primevue/calendar';
import Column, { ColumnFilterMatchModeOptions } from 'primevue/column';
import { IColumn, IndexData } from "@/types/index";
import Button from 'primevue/button';
import { RequestPayload } from '@inertiajs/core';
import { FilterMatchMode } from 'primevue/api';

const props = defineProps<{
    index: IndexData,
    columns?: IColumn[]
    customColumns?: IColumn[] | null | undefined
    action?: boolean
}>();

interface ILazyParams {
    page: number
    rows: number
    sortField?: string | ((item: any) => string)
    sortOrder?: 1 | 0 | -1 | undefined | null
    multiSortMeta?: DataTableSortMeta[] | null
    filters: DataTableFilterMeta
}

const windowSize = ref(window.screen.width < 600)

const filters = ref();
const dt = ref();
const payload = ref();
const multiSortMeta = ref();

const touch = ref(window.ontouchstart ?? true);

const lazyParams = ref<ILazyParams>({
    page: 1,
    rows: 10,
    filters: props.index?.filters,
    multiSortMeta: props.index?.multiSortMeta
});

const isDate = (column: IColumn) => {
    if (column.type === 'date' && column.filterable) {
        let filter = payload.value.filters[column.field] as DataTableFilterMeta;
        if (filter.value instanceof Date) {
            filter.value = dayjs(filter.value).format('YYYY-MM-DD');
        }
        return column;
    }
}

const loadLazyData = () => {
    payload.value = lazyParams.value;
    props.columns?.filter(isDate);

    router.get(route(route().current() as string), payload.value as RequestPayload, { preserveScroll: false, preserveState: true, queryStringArrayFormat: 'indices' })
}

const initFilters = () => {
    filters.value = props.index.filters;
    multiSortMeta.value = null;
    lazyParams.value.filters = props.index.filters;
    lazyParams.value.sortField = undefined;
    lazyParams.value.sortOrder = undefined;
    lazyParams.value.multiSortMeta = undefined;
};

initFilters();

const clearFilter = () => {
    lazyParams.value.multiSortMeta = undefined;
    router.get(route(route().current() as string), {}, { preserveScroll: false, preserveState: true, onFinish: initFilters });
};

const onFilter = (event: DataTableFilterEvent) => {
    lazyParams.value.filters = event.filters;
    loadLazyData();
}

const onSort = (event: DataTableSortEvent) => {
    lazyParams.value.sortField = event.sortField;
    lazyParams.value.sortOrder = event.sortOrder;
    lazyParams.value.multiSortMeta = event.multiSortMeta;
    loadLazyData();
}

const onPage = (event: DataTablePageEvent) => {
    lazyParams.value.page = event.page ? event.page + 1 : 1;
    lazyParams.value.rows = event.rows;
    loadLazyData();
}

const formatDateTime = (date: string) => {
    return dayjs(date).format('D MMMM YYYY HH:mm');
}

const formatDate = (date: string) => {
    return dayjs(date).format('D MMMM YYYY');
}


const matchModeOptions = (type: string | undefined): ColumnFilterMatchModeOptions[] => {
    switch (type) {
        case 'numeric':
            return [
                {label: 'Equals', value: FilterMatchMode.EQUALS},
                {label: 'Not Equals', value: FilterMatchMode.NOT_EQUALS},
                {label: 'Less Than', value: FilterMatchMode.LESS_THAN},
                {label: 'Less Than or Equal To', value: FilterMatchMode.LESS_THAN_OR_EQUAL_TO},
                {label: 'Greater Than', value: FilterMatchMode.GREATER_THAN},
                {label: 'Greater Than or Equal To', value: FilterMatchMode.GREATER_THAN_OR_EQUAL_TO},
            ]
        case 'date':
            // 'dateIs' | 'dateIsNot' | 'dateBefore' | 'dateAfter'
            return [
                {label: 'Date Is', value: FilterMatchMode.DATE_IS},
                {label: 'Date Is Not', value: FilterMatchMode.DATE_IS_NOT},
                {label: 'Date Before', value: FilterMatchMode.DATE_BEFORE},
                {label: 'Date After', value: FilterMatchMode.DATE_AFTER},
            ]
        case 'text':
        case 'string':
        default:
            return [
                {label: 'Contains', value: FilterMatchMode.CONTAINS},
                {label: 'Not Contains', value: FilterMatchMode.NOT_CONTAINS},
                {label: 'Equals', value: FilterMatchMode.EQUALS},
                {label: 'Not Equals', value: FilterMatchMode.NOT_EQUALS},
                {label: 'Starts With', value: FilterMatchMode.STARTS_WITH},
                {label: 'Ends With', value: FilterMatchMode.ENDS_WITH},
            ]
    }
}
</script>

<template>
    <DataTable
        v-bin
        :first="index.meta.from ?? 0"
        lazy
        removableSort
        showGridlines
        sortMode="multiple"
        ref="dt"
        :value="index.data"
        dataKey="id"
        filterDisplay="row"
        v-model:filters="filters"
        filterLocale="id"
        paginator
        :rows="index.meta.per_page"
        :rowsPerPageOptions="[5, 10, 20, 50]"
        :totalRecords="index.meta.total"
        :loading="false"
        @filter="onFilter($event)"
        @sort="onSort($event)"
        @page="onPage($event)"
    >
        <template #header>
            <div class="flex justify-items-end justify-between">
                <Button type="button" icon="pi pi-filter-slash" label="Clear" rounded outlined @click="clearFilter()" />
                <Link :href="route((route().current() as string).replace('index', 'create'))" as="button" ><Button type="button" icon="pi pi-plus" label="Add" rounded /></Link>
            </div>
        </template>

        <template class="text-center" #empty> No data found. </template>

        <Column v-for="col of columns" :field="col.field" :header="col.header" :sortable="col.sortable"
            :dataType="col.type"
            showClearButton
            :showApplyButton="col.type !== 'date'"
            :showFilterMenu="col.filterable"
            :showFilterOperator="true"
            :showFilterMatchModes="true"
            :filterMatchModeOptions="matchModeOptions(col.type)"
        >
            <template #body="{ data, field }">
                <div v-if="col.type === 'date'">{{ formatDate(data[field]) }}</div>
                <div v-else-if="col.type === 'image'"><img src="#" alt="Image" /></div>
                <div v-else>{{ data[field] }}</div>
            </template>
            <template #filter="{ filterModel, filterCallback }" v-if="col.filterable">
                <InputNumber v-if="col.type === 'numeric'" v-model="filterModel.value" allowEmpty @change="filterCallback()"
                    class="p-column-filter" :placeholder="'Search by ' + col.header" />

                <Calendar v-else-if="col.type === 'date'" v-model="filterModel.value" @hide="filterCallback()" :touchUI="windowSize"
                    dateFormat="yy-mm-dd" placeholder="yyyy-mm-dd" :mask="dayjs().format('YYYY-MM-DD')" showIcon appendTo="body" />

                <InputText v-else v-model="filterModel.value" type="text" @change="filterCallback()" class="p-column-filter"
                    :placeholder="'Search by ' + col.header" />
            </template>
        </Column>

        <Column v-if="action" header="Action">
            <template #body="{ data, field }">
                <slot name="action" :data="data" :field="field" />
            </template>
        </Column>
    </DataTable>
</template>
