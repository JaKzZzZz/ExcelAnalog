import { loadTable } from "./api/api.js";

import {
    renderTable
} from "./table/renderTable.js";


import {
    state
} from "./state.js";


import "./resize/resizeMove.js";



await loadTable();


renderTable();