export function getCellSize() {

    const styles = getComputedStyle(
        document.documentElement
    );


    return {
        width: parseInt(
            styles.getPropertyValue("--cell-width")
        ),

        height: parseInt(
            styles.getPropertyValue("--cell-height")
        )
    };

}