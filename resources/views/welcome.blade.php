//Reusable code
<tbody>
    <?php if ($rows > 0): ?>
        <?php foreach ($result as $row): ?>
            <tr>
                <?php foreach ($row as $column): ?>
                    <td><?= $column ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?= count($columns) - 1 ?>">No results found</td>
        </tr>
    <?php endif; ?>
</tbody>





<!-- //settings reusable code -->
<div class="warpper">
                            <input class="radio" id="one" name="group" type="radio" checked>
                            <input class="radio" id="two" name="group" type="radio">
                            <input class="radio" id="three" name="group" type="radio">
                            <input class="radio" id="four" name="group" type="radio">

                            <div class="tabs">
                                <label class="tab" id="one-tab" for="one">Users Settings</label>
                                <label class="tab" id="two-tab" for="two">Implementation Status</label>
                                <label class="tab" id="three-tab" for="three">Acceptance Status</label>
                                <label class="tab" id="four-tab" for="four">SAI Confirmation</label>
                            </div>

                            <script>
                                const tabs = document.querySelectorAll('.tab');

                                tabs.forEach(tab => {
                                    tab.addEventListener('click', () => {
                                        const tabId = tab.getAttribute('for');
                                        window.location.hash = tabId;
                                    });
                                });
                            </script>

                            <div class="panels">

                                <!-- User Settings Tab -->
                                <div class="panel" id="one-panel">
                                    <div class="panel-title">Users</div>
                                    <div class="download-wrapper">
                                        <a href="{{ route('createuser') }}" class=""><i class="fa fa-plus"></i> Add New User</a>
                                    </div>
                                    <div class="user-section">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                @foreach(array_keys($users[0]) as $key)
                                                    @if($key !== 'id')
                                                        <th>{{ $key }}</th>
                                                    @endif
                                                @endforeach
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    @foreach($user as $key => $value)
                                                        @if($key !== 'id')
                                                            <td>{{ $value }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>
                                                        <a href="{{ route('updateuser', ['id' => $user['id']]) }}" class="mr-3"
                                                        title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                                        <a href="{{ route('deleteuser', ['id' => $user['id']]) }}" title="Delete Record"
                                                        data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Implementation Status Tab -->
                                <div class="panel" id="two-panel">
                                    <div class="panel-title">Implementation</div>

                                    <div id="impl_status">
                                        @if(isset($data_recommendations))
                                            <table>
                                                <thead>
                                                <tr>
                                                    @foreach(array_keys($data_recommendations[0]) as $key)
                                                        <th>{{ $key }}</th>
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data_recommendations as $row)
                                                    <tr>
                                                        @foreach($row as $key => $value)
                                                            @if($key === 'implementation_status')
                                                                <td>
                                                                    {{ $value }}
                                                                    <form method="post" style="display:inline">
                                                                        <input type="hidden" name="impl_report_number"
                                                                            value="{{ $row['report_numbers'] }}">
                                                                        <select name="impl_new_status">
                                                                            <option value="Fully Implemented"
                                                                                    {{ $value == 'Fully Implemented' ? 'selected' : '' }}>
                                                                                Fully Implemented
                                                                            </option>
                                                                            <option value="Partially Implemented"
                                                                                    {{ $value == 'Partially Implemented' ? 'selected' : '' }}>
                                                                                Partially Implemented
                                                                            </option>
                                                                            <option value="Ongoing"
                                                                                    {{ $value == 'Ongoing' ? 'selected' : '' }}>
                                                                                Ongoing
                                                                            </option>
                                                                            <option value="Not Implemented"
                                                                                    {{ $value == 'Not Implemented' ? 'selected' : '' }}>
                                                                                Not Implemented
                                                                            </option>
                                                                        </select>
                                                                        <button type="submit">Update</button>
                                                                    </form>
                                                                </td>
                                                            @else
                                                                <td>{{ $value }}</td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>No data to display.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Acceptance Status Tab -->
                                <div class="panel" id="three-panel">
                                    <div class="panel-title">Acceptance Status</div>

                                    @if(isset($data_acceptance))
                                        <table>
                                            <thead>
                                            <tr>
                                                @foreach(array_keys($data_acceptance[0]) as $key)
                                                    <th>{{ $key }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data_acceptance as $row)
                                                <tr>
                                                    @foreach($row as $key => $value)
                                                        @if($key === 'acceptance_status')
                                                            <td>
                                                                {{ $value }}
                                                                <form method="post" style="display:inline">
                                                                    <input type="hidden" name="acc_report_number"
                                                                        value="{{ $row['report_numbers'] }}">
                                                                    <select name="acc_new_status">
                                                                        <option value="Accepted"
                                                                                {{ $value == 'Accepted' ? 'selected' : '' }}>
                                                                            Accepted
                                                                        </option>
                                                                        <option value="Denied"
                                                                                {{ $value == 'Denied' ? 'selected' : '' }}>
                                                                            Denied
                                                                        </option>
                                                                    </select>
                                                                    <button type="submit">Update</button>
                                                                </form>
                                                            </td>
                                                        @else
                                                            <td>{{ $value }}</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No data to display.</p>
                                    @endif
                                </div>

                                <!-- SAI Confirmation Tab -->
                                <div class="panel" id="four-panel">
                                    <div class="panel-title">SAI Confirmation</div>

                                    @if(isset($data_confirmation))
                                        <table>
                                            <thead>
                                            <tr>
                                                @foreach(array_keys($data_confirmation[0]) as $key)
                                                    <th>{{ $key }}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data_confirmation as $row)
                                                <tr>
                                                    @foreach($row as $key => $value)
                                                        @if($key === 'sai_confirmation')
                                                            <td>
                                                                {{ $value }}
                                                                <form method="post" style="display:inline">
                                                                    <input type="hidden" name="sai_report_number"
                                                                        value="{{ $row['report_numbers'] }}">
                                                                    <select name="sai_new_status">
                                                                        <option value="Yes" {{ $value == 'Yes' ? 'selected' : '' }}>
                                                                            Yes
                                                                        </option>
                                                                        <option value="No" {{ $value == 'No' ? 'selected' : '' }}>
                                                                            No
                                                                        </option>
                                                                    </select>
                                                                    <button type="submit">Update</button>
                                                                </form>
                                                            </td>
                                                        @else
                                                            <td>{{ $value }}</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No data to display.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                   