import DataTable, { DataTableFilterMeta, DataTableFilterEvent, DataTablePageEvent } from "primevue/datatable";
import { ToastMessageOptions } from "primevue/toast";

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface IndexMeta {
    current_page: number,
    /**
     * Start data.
     */
    from?: number | undefined,
    last_page: number,
    links: any,
    path: string,
    /**
     * Per page data.
     */
    per_page: number,
    to: number,
    /**
     * Total data.
     */
    total: number,
}

export type IndexData = {
    /**
     * Data for data table.
     */
    data: any | null,
    /**
     * Set per page
     */
    per_page: number,
    filters: DataTableFilterMeta,
    multiSortMeta: DataTableSortMeta[] | null,
    /**
     * Meta data.
     */
    meta: IndexMeta
}

export interface IDataTable {
    index: IndexData,
    columns: Array<IColumn>
}

export type IColumn = {
    field: string,
    header: string,
    sortable?: boolean,
    filterable?: boolean
    type?: "string" | "date" | "numeric" | "image" | string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    toast?: ToastMessageOptions
};
