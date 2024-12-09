
import Echo from "laravel-echo"

window.Echo.channel('new-final-report')
    .listen('insertFinalReports', (event) => {
        console.log('New Final Report:', event.insertFinalReports);

        // Append or trigger the method to insert into the database
        appendNewFinalReportToTable(event.insertFinalReports);
    });

function appendNewFinalReportToTable(insertFinalReports) {
    // Assuming you have a function to append data to the table
    // Update this based on your actual table structure
    // You can use jQuery or plain JavaScript to manipulate the DOM

    // Example using jQuery:
    $('table tbody').append(`
    <tr>
        <td>${insertFinalReports.country_office}</td>
        <td>${insertFinalReports.audit_report_title}</td>
        <td>${insertFinalReports.date_of_audit}</td>
        <td>${insertFinalReports.publication_date}</td>
        <td>${insertFinalReports.page_par_reference}</td>
        <td>${insertFinalReports.audit_recommendations}</td>
        <td>${insertFinalReports.lead_body}</td>
        <td>${insertFinalReports.key_issues}</td>
        <td>${insertFinalReports.acceptance_status}</td>
        <td>${insertFinalReports.current_implementation_status}</td>
        <td>${insertFinalReports.target_completion_date}</td>
        <td>${insertFinalReports.follow_up_date}</td>
        <td>${insertFinalReports.action_plan}</td>
        <td>${insertFinalReports.responsible_person}</td>
        <td>${insertFinalReports.sai_confirmation}</td>
        <td>${insertFinalReports.responsible_entity}</td>
        <td>${insertFinalReports.head_of_audited_entity}</td>
        <td>${insertFinalReports.audited_entity_focal_point}</td>
        <td>${insertFinalReports.audit_team_lead}</td>
        <td>${insertFinalReports.summary_of_responce}</td>
    </tr>
`);

}
