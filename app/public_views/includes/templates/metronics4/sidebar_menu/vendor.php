<?php $path = ''; ?> 
<?php if ($_var_template->_module == 'vendor'): ?>
    <?php if (isset($_menu) && !empty($_menu)): ?>
        <li class="heading">
            <h3 class="uppercase"><?php echo $_menu['text'] . ' ' . $_var_template->_module; ?></h3>
        </li>
        <?php if (isset($_menu['nodes']) && !empty($_menu['nodes'])): ?>
            <?php foreach ($_menu['nodes'] AS $key => $values): ?>
                <li class="nav-item<?php echo ($values['is_open'] == 1) ? ' open' : ''; ?>">
                    <a data-path="<?php echo ($values['menu_path'] != '#') ? $values['menu_path'] : '#'; ?>" href="<?php echo $path = ($values['menu_path'] == '#' || $values['menu_path'] == '') ? 'javascript:;' : base_url($values['menu_path']); ?>" class="nav-link <?php echo $path = ($values['menu_path'] == '#' || $values['menu_path'] == '') ? 'nav-toggle' : ''; ?>">
                        <i class="fa <?php echo $values['menu_icon']; ?>"></i>
                        <span class="title"><?php echo $values['menu_text']; ?></span>
                        <?php if ($values['is_badge'] == 0): ?>
                            <?php echo $path = ($values['menu_path'] == '#' || $values['menu_path'] == '') ? '<span class="arrow"></span>' : ''; ?>
                        <?php else: ?>
                            <?php if ($values['menu_text'] == 'Transfer'): ?>
                                <span class="bdge" style="float:right"></span>
                            <?php elseif ($values['menu_text'] == 'Progress'): ?>
                                <span class="bdge_prog" style="float:right"></span>
                            <?php else: ?>
                                <span class="badge badge-roundless" style="background-color:<?php echo!empty($values['badge']) ? $values['badge'] : 'grey'; ?>" id="<?php echo ($values['menu_text'] != '') ? $values['menu_text'] : '#'; ?>"></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                    <?php if (isset($values['nodes']) && !empty($values['nodes'])): ?>
                        <ul class="sub-menu"<?php echo ($values['is_open'] == 1) ? ' style="display: block"' : ''; ?>>
                            <?php foreach ($values['nodes'] AS $k => $val): ?>
                                <li class="nav-item<?php echo ($val['is_open'] == 1) ? ' open' : ''; ?>">
                                    <a data-path="<?php echo ($val['menu_path'] != '#') ? $val['menu_path'] : '#'; ?>" href="<?php echo $path = ($val['menu_path'] == '#' || $val['menu_path'] == '') ? 'javascript:;' : base_url($val['menu_path']); ?>" class="nav-link <?php echo $path = ($val['menu_path'] == '#' || $val['menu_path'] == '') ? 'nav-toggle' : ''; ?>">
                                        <i class="fa <?php echo $val['menu_icon']; ?>"></i>
                                        <span class="title"><?php echo $val['menu_text']; ?></span>                                        
                                        <?php if ($val['is_badge'] == 0): ?>
                                            <?php echo $path = ($val['menu_path'] == '#' || $val['menu_path'] == '') ? '<span class="arrow"></span>' : ''; ?>
                                        <?php else: ?>
                                            <?php if ($val['menu_text'] == 'Transfer'): ?>
                                                <span class="bdge" style="float:right"></span>
                                            <?php elseif ($val['menu_text'] == 'Progress'): ?>
                                                <span class="bdge_prog" style="float:right"></span>
                                            <?php else: ?>
                                                <span class="badge badge-roundless" style="background-color:<?php echo!empty($val['badge']) ? $val['badge'] : 'grey'; ?>" id="<?php echo ($val['menu_text'] != '') ? str_replace(' ', '', $val['menu_text']) : ''; ?>"></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </a>
                                    <?php if (isset($val['nodes']) && !empty($val['nodes'])): ?>
                                        <ul class="sub-menu"<?php echo ($val['is_open'] == 1) ? ' style="display: block"' : ''; ?>>
                                            <?php foreach ($val['nodes'] AS $k => $v): ?>
                                                <li class="nav-item<?php echo ($v['is_open'] == 1) ? ' open' : ''; ?>">
                                                    <a data-path="<?php echo ($v['menu_path'] != '#') ? $v['menu_path'] : '#'; ?>" href="<?php echo $path = ($v['menu_path'] == '#' || $v['menu_path'] == '') ? 'javascript:;' : base_url($v['menu_path']); ?>" class="nav-link <?php echo $path = ($v['menu_path'] == '#' || $v['menu_path'] == '') ? 'nav-toggle' : ''; ?>">
                                                        <i class="fa<?php echo $v['menu_icon']; ?>"></i>
                                                        <span class="title"><?php echo $v['menu_text']; ?></span>
                                                        <?php if ($v['is_badge'] == 1): ?>
                                                            <?php if ($v['menu_text'] == 'Transfer'): ?>
                                                                <span class="bdge" style="float:right"></span>
                                                            <?php elseif ($v['menu_text'] == 'Progress'): ?>
                                                                <span class="bdge_prog" style="float:right"></span>
                                                            <?php else: ?>
                                                                <span class="badge badge-roundless" style="background-color:<?php echo!empty($v['badge']) ? $v['badge'] : 'grey'; ?>" id="<?php echo ($v['menu_text'] != '') ? str_replace(' ', '', $v['menu_text']) : ''; ?>"></span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>		
        <?php endif; ?>
    <?php endif; ?>	
<?php endif; ?>