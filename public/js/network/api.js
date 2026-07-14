import { state } from "../state.js";

import { showStatus } from "../ui/status.js";

const API_URL = document
    .querySelector('meta[name="api-url"]')
    .content;


export async function loadTable() {

    try {

        const response =
            await fetch(API_URL);


        if (!response.ok) {

            throw new Error(
                `Ошибка загрузки: ${response.status}`
            );

        }


        const data =
            await response.json();



        state.rows = data.rows;

        state.columns = data.columns;

        state.cells = data.cells ?? {};



        if(Array.isArray(state.cells)) {

            state.cells = {};

        }


    } 
    
    catch (error) {

        console.error(
            "Ошибка при загрузке таблицы:",
            error
        );

        showStatus(
        "Не удалось загрузить таблицу",
        "error");

        throw error;
    }

}





export async function saveTable() {

    try {

        const response =
            await fetch(API_URL, {


                method:"POST",


                headers:{
                    "Content-Type":"application/json"
                },


                body:JSON.stringify(state)


            });



        if (!response.ok) {

            throw new Error(
                `Ошибка сохранения: ${response.status}`
            );

        }

        const data =
            await response.json();


        if(!data.success){

            throw new Error(
                "Сервер не подтвердил сохранение"
            );

        }

        showStatus(
        "Сохранение прошло успешно",
        "success")


    }

    catch (error) {

        console.error(
            "Ошибка при сохранении таблицы:",
            error
        );

        showStatus(
        "Не удалось сохранить таблицу",
        "error"
    );


    }

}
export async function updateCell(row, col, value) {

    try {

        const response =
            await fetch(API_URL, {


                method:"PATCH",


                headers:{
                    "Content-Type":"application/json"
                },


                body: JSON.stringify({
                    row,
                    col,
                    value
                })


            });

        



        if (!response.ok) {

            throw new Error(
                `Ошибка обновления: ${response.status}`
            );

        }

        const data =
            await response.json();


        if(!data.success){

            throw new Error(
                "Сервер не подтвердил обновление"
            );

        }

        showStatus(
        "Обновление прошло успешно",
        "success")


    }

    catch (error) {

        console.error(
            "Ошибка при обновлении таблицы:",
            error
        );

        showStatus(
        "Не удалось обновить таблицу",
        "error"
    );


    }

}





let saveTimeout = null;


export function updateCellDelayed(row, col, value) {

    clearTimeout(saveTimeout);


    saveTimeout = setTimeout(async () => {

        updateCell(row, col, value);

    }, 300);

}