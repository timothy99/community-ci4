                                        <form id="update_form_<?=$info->bc_idx ?>">
                                            <td colspan="2"><textarea class="form-control" id="comment_<?=$info->bc_idx ?>" name="comment_<?=$info->bc_idx ?>" rows="4"><?=$info->comment ?></textarea></td>
                                            <td style="width:70px"><button type="button" class="btn btn-xs btn-info" onclick="comment_update(<?=$info->bc_idx ?>)">저장</button></td>
                                        </form>
