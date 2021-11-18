<script type="text/javascript">

const clickMores = document.querySelectorAll(".clickMore");            
for (let i=0; i<clickMores.length; i++) {                    
    clickMores[i].addEventListener('click', (e) => {                    
        const readMoreText = e.target.parentNode.querySelector(".moreText");
        readMoreText.classList.toggle('inv');
        if (clickMores[i].textContent == "...Read More") {
            clickMores[i].textContent = "..Less";
        } else {
            clickMores[i].textContent = "...Read More";
        }                     
    });
}

function sortTable() {   
    let table, rows, switching, i, x, y, shouldSwitch;            
    table = document.querySelector(".resultsTable");                
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
    //start by saying: no switching is done:
        switching = false;
        rows = table.querySelectorAll(".resultRow");
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 0; i < (rows.length-1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].querySelector(".dateCol");
            y = rows[i + 1].querySelector(".dateCol");
            //check if the two rows should switch place:
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            //if so, mark as a switch and break the loop:
                shouldSwitch= true;
                break;
            }
        }

        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

sortTable();

</script>