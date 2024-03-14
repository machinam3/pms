@foreach ($users as $user)
    <tr>
        <th scope="row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
            </div>
        </th>
        <td class="id" style="display:none;"><a href="javascript:void(0);"
                class="fw-medium link-primary">{{ $user->id }}</a></td>
        <td class="user_name">{{ $user->name }}</td>
        <td class="email">{{ $user->email }}</td>
        <td class="phone">{{ $user->role->name }}</td>
        <td class="date">{{ $user->created_at }}</td>
        <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">Active</span>
        </td>
        <td>
            <ul class="list-inline hstack gap-2 mb-0">
                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover"
                    data-bs-placement="top" title="Edit">
                    <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                        <i class="ri-pencil-fill fs-16"></i>
                    </a>
                </li>
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                    title="Remove">
                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                        href="#deleteRecordModal">
                        <i class="ri-delete-bin-5-fill fs-16"></i>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
@endforeach
