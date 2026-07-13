import { state } from "../state.js";

const API_URL = "/public/api/table.php";


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


    }

    catch (error) {

        console.error(
            "Ошибка при сохранении таблицы:",
            error
        );

    }

}





let saveTimeout = null;


export function saveTableDelayed() {

    clearTimeout(saveTimeout);


    saveTimeout = setTimeout(async () => {

        saveTable();

    }, 300);

}