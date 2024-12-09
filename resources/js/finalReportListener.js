
import Echo from "laravel-echo"

window.Echo.channel('new-final-report')
    .listen('NewFinalReport', (event) => {
        console.log('New Final Report:', event.newFinalReport);

        // Append or trigger the method to insert into the database
        appendNewFinalReportToTable(event.newFinalReport);
    });

function appendNewFinalReportToTable(newFinalReport) {
    // Assuming you have a function to append data to the table
    // Update this based on your actual table structure
    // You can use jQuery or plain JavaScript to manipulate the DOM

    // Example using jQuery:
    $('table tbody').append(`
        <tr>
            <td>${newFinalReport.country_office}</td>
            <td>${newFinalReport.audit_report_title}</td>
            <!-- Add other columns accordingly -->
        </tr>
    `);
}
