import { loadTable } from "./network/api.js";

import {
    renderTable
} from "./table/renderTable.js";


import "./resize/resizeMove.js";


try {

    await loadTable();

    document.addEventListener(
        "table:changed",
        () => {
            renderTable();
        }
    );

    renderTable();
}
catch (error) {

    console.error(
        "Ошибка при инициализации таблицы:",
        error
    );
}